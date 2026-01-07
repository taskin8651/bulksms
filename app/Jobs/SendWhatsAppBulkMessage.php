<?php

namespace App\Jobs;

use App\Models\WhatsApp;
use App\Models\WhatsAppMessageLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWhatsAppBulkMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $whatsAppId;

    // Optional: retry settings
    public int $tries = 3;
    public int $timeout = 30;

    public function __construct(int $whatsAppId)
    {
        $this->whatsAppId = $whatsAppId;
    }

    public function handle(): void
    {
        // 🔹 Load campaign safely
        $whatsApp = WhatsApp::with('setup')->find($this->whatsAppId);

        if (!$whatsApp) {
            Log::error("Campaign NOT FOUND | ID: {$this->whatsAppId}");
            return;
        }

        $setup = $whatsApp->setup;

        if (!$setup || (int)$setup->status !== 1) {
            Log::error("WhatsApp setup missing/inactive | Campaign ID: {$whatsApp->id}");
            return;
        }

        // 🔹 Fetch pending logs
        $logs = WhatsAppMessageLog::with('contact')
            ->where('whatsapp_id', $whatsApp->id)
            ->where('status', 'pending')
            ->get();

        if ($logs->isEmpty()) {
            Log::info("No pending logs | Campaign ID: {$whatsApp->id}");
            return;
        }

        foreach ($logs as $log) {
            try {
                $contact = $log->contact;

                if (!$contact || empty($contact->phone_number)) {
                    throw new \Exception('Contact phone number missing');
                }

                // 🔥 EXACT META QUICKSTART PAYLOAD (TEST MODE)
                $payload = [
                    'messaging_product' => 'whatsapp',
                    'to' => $contact->phone_number, // e.g. 918651323192
                    'type' => 'template',
                    'template' => [
                        'name' => 'hello_world',
                        'language' => [
                            'code' => 'en_US',
                        ],
                    ],
                ];

                $url = "https://graph.facebook.com/{$setup->api_version}/{$setup->phone_number_id}/messages";

                Log::info('WhatsApp API REQUEST', [
                    'campaign_id' => $whatsApp->id,
                    'log_id' => $log->id,
                    'url' => $url,
                    'to' => $contact->phone_number,
                ]);

                $response = Http::withToken($setup->access_token)
                    ->acceptJson()
                    ->timeout(20)
                    ->post($url, $payload);

                if ($response->successful()) {
                    $log->update([
                        'status' => 'sent',
                        'message_id' => $response->json('messages.0.id'),
                        'response_payload' => $response->json(),
                    ]);
                } else {
                    $log->update([
                        'status' => 'failed',
                        'error_message' => $response->body(),
                        'response_payload' => $response->json(),
                    ]);

                    Log::error('WhatsApp API FAILED', [
                        'log_id' => $log->id,
                        'status' => $response->status(),
                        'response' => $response->json(),
                    ]);
                }

                // Rate-limit safety
                sleep(1);

            } catch (\Throwable $e) {
                $log->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

                Log::error("WhatsApp JOB ERROR | Log {$log->id}", [
                    'exception' => $e->getMessage(),
                ]);
            }
        }

        // 🔹 Mark campaign completed if nothing pending
        $pendingCount = WhatsAppMessageLog::where('whatsapp_id', $whatsApp->id)
            ->where('status', 'pending')
            ->count();

        if ($pendingCount === 0) {
            WhatsApp::where('id', $whatsApp->id)
                ->update(['status' => 'completed']);

            Log::info("Campaign COMPLETED | ID: {$whatsApp->id}");
        }
    }
}
