<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsAppMessageLog extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'whatsapp_message_logs';

    protected $fillable = [
        'whatsapp_id',
        'contact_id',
        'message_id',
        'message',
        'status',
        'error_message',
        'response_payload',
    ];

    protected $casts = [
        'response_payload' => 'array',
    ];

    public function campaign()
    {
        return $this->belongsTo(WhatsApp::class, 'whatsapp_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
