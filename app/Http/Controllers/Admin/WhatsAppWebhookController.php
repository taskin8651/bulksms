<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsAppSetup;
use App\Models\Lead;
use App\Models\MessageLog;
use App\Models\ChatbotRule;

class WhatsAppWebhookController extends Controller
{
    /**
     * Webhook verification (Meta requirement)
     */
    public function verify(Request $request)
    {
        $verifyToken = $request->get('hub_verify_token');
        $challenge   = $request->get('hub_challenge');

        $setup = WhatsAppSetup::where('verify_token', $verifyToken)
            ->where('status', 'active')
            ->first();

        if ($setup) {
            return response($challenge, 200);
        }

        return response('Invalid verify token', 403);
    }

    /**
     * Handle incoming WhatsApp messages
     */
    public function handle(Request $request)
    {
        Log::info('WhatsApp Webhook Hit', $request->all());

        $entry = $request->input('entry.0.changes.0.value');

        if (!$entry || !isset($entry['messages'][0])) {
            return response()->json(['status' => 'ignored']);
        }

        $message  = $entry['messages'][0];
        $from     = $message['from']; // user mobile
        $text     = $message['text']['body'] ?? '';
        $phoneId  = $entry['metadata']['phone_number_id'];

        // Find WhatsApp setup
        $setup = WhatsAppSetup::where('phone_number_id', $phoneId)
            ->where('status', 'active')
            ->first();

        if (!$setup) {
            Log::warning('No WhatsApp setup found', ['phone_number_id' => $phoneId]);
            return response()->json(['status' => 'no_setup']);
        }

        // Create or find lead
        $lead = Lead::firstOrCreate(
            [
                'mobile'        => $from,
                'created_by_id' => $setup->created_by_id,
            ],
            [
                'status'       => 'new',
                'current_step' => 1,
            ]
        );

        // Save incoming message
        MessageLog::create([
            'lead_id'   => $lead->id,
            'direction' => 'in',
            'message'   => $text,
        ]);

        // Run dynamic chatbot
        $this->runDynamicChatbot($lead, trim($text), $setup);

        return response()->json(['status' => 'success']);
    }

    /**
     * Run dynamic chatbot based on user-defined rules
     */
    private function runDynamicChatbot($lead, $text, $setup)
    {
        $text = strtolower(trim($text));

        $rules = ChatbotRule::where('whatsapp_setup_id', $setup->id)
            ->where('is_active', 1)
            ->orderBy('priority', 'asc')
            ->get();

        $matched = false;
        $defaultReply = null;

        foreach ($rules as $rule) {
            $trigger = strtolower($rule->trigger_value);

            if ($rule->trigger_type == 'exact' && $text === $trigger) {
                $this->sendMessage($lead->mobile, $rule->reply_message, $setup);
                $matched = true;
                break;
            }

            if ($rule->trigger_type == 'contains' && str_contains($text, $trigger)) {
                $this->sendMessage($lead->mobile, $rule->reply_message, $setup);
                $matched = true;
                break;
            }

            if ($rule->trigger_type == 'starts_with' && str_starts_with($text, $trigger)) {
                $this->sendMessage($lead->mobile, $rule->reply_message, $setup);
                $matched = true;
                break;
            }

            if ($rule->trigger_type == 'default') {
                $defaultReply = $rule->reply_message;
            }
        }

        // Send fallback if no match
        if (!$matched && $defaultReply) {
            $this->sendMessage($lead->mobile, $defaultReply, $setup);
        }
    }

    /**
     * Send WhatsApp message (Meta Cloud API)
     */
    private function sendMessage($to, $text, $setup)
    {
        try {
            Http::withToken($setup->access_token)
                ->post(
                    "https://graph.facebook.com/{$setup->api_version}/{$setup->phone_number_id}/messages",
                    [
                        'messaging_product' => 'whatsapp',
                        'to'   => $to,
                        'type' => 'text',
                        'text' => [
                            'body' => $text
                        ],
                    ]
                );

            MessageLog::create([
                'lead_id'   => null,
                'direction' => 'out',
                'message'   => $text,
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp send error', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
