<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ChatbotAnalytic extends Model
{
    use HasFactory;

    protected $fillable = [
        'chatbot_rule_id',
        'created_by_id',
        'user_message',
        'matched_keyword',
    ];

    public function chatbotRule()
    {
        return $this->belongsTo(ChatbotRule::class, 'chatbot_rule_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
