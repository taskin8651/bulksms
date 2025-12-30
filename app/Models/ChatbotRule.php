<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ChatbotRule extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'whatsapp_setup_id',
        'created_by_id',
        'trigger_type',
        'trigger_value',
        'reply_message',
        'is_active',
        'priority',
    ];

    /**
     * Relation with WhatsAppSetup
     */
    public function whatsappSetup()
    {
        return $this->belongsTo(WhatsAppSetup::class);
    }

    /**
     * Relation with User (Admin or Creator)
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Register Media Collections for CKEditor
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('ck-media')->singleFile(); // Single file or remove singleFile() for multiple
    }

    /**
     * Optional: Accessor for active/inactive status
     */
    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
}
