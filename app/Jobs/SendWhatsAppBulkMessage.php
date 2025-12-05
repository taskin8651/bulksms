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

    protected $whatsApp;

    /**
     * Create a new job instance.
     *
     * @param WhatsApp $whatsApp
     */
    public function __construct(WhatsApp $whatsApp)
    {
        $this->whatsApp = $whatsApp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $template = $this->whatsApp->template;

        if (!$template) {
            Log::warning("WhatsApp campaign ID {$this->whatsApp->id} has no template.");
            return;
        }

        foreach ($this->whatsApp->contacts as $contact) {
            try {
                // --------------------------
                // DUMMY MODE: Test sending
                // --------------------------
                Log::info("Sending WhatsApp to {$contact->whatsapp_number}");
                Log::info("Message: {$template->body}");

                // If you want real API call, uncomment below:
                /*
                $response = Http::withToken(config('services.whatsapp.access_token'))
                    ->post('https://graph.facebook.com/v17.0/' . config('services.whatsapp.phone_number_id') . '/messages', [
                        'messaging_product' => 'whatsapp',
                        'to' => $contact->whatsapp_number,
                        'type' => 'template',
                        'template' => [
                            'name' => $template->template_name,
                            'language' => ['code' => 'en_US'],
                            'components' => [[
                                'type' => 'body',
                                'parameters' => [['type' => 'text', 'text' => $template->body]]
                            ]]
                        ]
                    ]);

                $status = $response->successful() ? 'sent' : 'failed';
                $responseBody = $response->body();
                */

                // --------------------------
                // For dummy/test, just mark as sent
                // --------------------------
                $status = 'sent';
                $responseBody = 'DUMMY TEST MODE';

                WhatsAppMessageLog::create([
                    'whats_app_id' => $this->whatsApp->id,
                    'contact_id'   => $contact->id,
                    'message'      => $template->body,
                    'status'       => $status,
                    'response'     => $responseBody,
                ]);

            } catch (\Exception $e) {
                WhatsAppMessageLog::create([
                    'whats_app_id' => $this->whatsApp->id,
                    'contact_id'   => $contact->id,
                    'message'      => $template->body,
                    'status'       => 'failed',
                    'response'     => $e->getMessage(),
                ]);
                Log::error("WhatsApp sending failed for {$contact->whatsapp_number}: " . $e->getMessage());
            }
        }

        $this->whatsApp->update(['status' => 'completed']);
    }
}
