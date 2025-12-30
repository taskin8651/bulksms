<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatbotRule;
use App\Models\WhatsAppSetup;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ChatbotRuleController extends Controller
{
    use \App\Http\Controllers\Traits\MediaUploadingTrait;

    public function index()
    {
        $rules = ChatbotRule::where('created_by_id', Auth::id())
                    ->orderBy('priority', 'asc')
                    ->get();

        return view('admin.chatbot_rules.index', compact('rules'));
    }

    public function create()
    {
        return view('admin.chatbot_rules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trigger_type' => 'required|string',
            'reply_message' => 'required|string',
            'priority' => 'required|integer',
        ]);

        $setup = WhatsAppSetup::where('created_by_id', Auth::id())->firstOrFail();

        $rule = ChatbotRule::create([
            'whatsapp_setup_id' => $setup->id,
            'created_by_id' => Auth::id(),
            'trigger_type' => $request->trigger_type,
            'trigger_value' => $request->trigger_value,
            'reply_message' => $request->reply_message,
            'priority' => $request->priority,
            'is_active' => $request->is_active ?? 1,
        ]);

        // CKEditor uploaded images
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $rule->id]);
        }

        return redirect()->route('admin.chatbot.rules.index')->with('success', 'Rule added successfully.');
    }

    public function edit(ChatbotRule $rule)
    {
        return view('admin.chatbot_rules.edit', compact('rule'));
    }

    public function update(Request $request, ChatbotRule $rule)
    {
        $request->validate([
            'trigger_type' => 'required|string',
            'reply_message' => 'required|string',
            'priority' => 'required|integer',
        ]);

        $setup = WhatsAppSetup::where('created_by_id', Auth::id())->firstOrFail();

        $rule->update([
            'whatsapp_setup_id' => $setup->id,
            'trigger_type' => $request->trigger_type,
            'trigger_value' => $request->trigger_value,
            'reply_message' => $request->reply_message,
            'priority' => $request->priority,
            'is_active' => $request->is_active ?? 1,
        ]);

        // CKEditor uploaded images
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $rule->id]);
        }

        return redirect()->route('admin.chatbot.rules.index')->with('success', 'Rule updated successfully.');
    }

    public function destroy(ChatbotRule $rule)
    {
        $rule->delete();
        return redirect()->route('admin.chatbot.rules.index')->with('success', 'Rule deleted successfully.');
    }

    public function storeCKEditorImages(Request $request)
    {
        $model = new ChatbotRule();
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
public function testPage()
{
    $rules = ChatbotRule::where('created_by_id', Auth::id())
        ->where('is_active', 1)
        ->whereNotNull('trigger_value')
        ->where('trigger_type', '!=', 'default')
        ->orderBy('priority', 'asc')
        ->get(['trigger_value']);

    return view('admin.chatbot_rules.test', compact('rules'));
}


    public function testBot(Request $request)
{
    $message = strtolower(trim($request->message));

    $rules = ChatbotRule::where('created_by_id', Auth::id())
        ->where('is_active', 1)
        ->orderBy('priority', 'asc')
        ->get();

    foreach ($rules as $rule) {
        if ($rule->trigger_type == 'exact' && $message === strtolower($rule->trigger_value)) {
            return response()->json(['reply' => $rule->reply_message]);
        }

        if ($rule->trigger_type == 'contains' && str_contains($message, strtolower($rule->trigger_value))) {
            return response()->json(['reply' => $rule->reply_message]);
        }

        if ($rule->trigger_type == 'starts_with' && str_starts_with($message, strtolower($rule->trigger_value))) {
            return response()->json(['reply' => $rule->reply_message]);
        }

        if ($rule->trigger_type == 'default') {
            $defaultReply = $rule->reply_message;
        }
    }

    return response()->json([
        'reply' => $defaultReply ?? 'Sorry, samajh nahi aaya 😔'
    ]);
}

}
