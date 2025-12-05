<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsAppSetup extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'whats_app_setups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const PROVIDER_NAME_SELECT = [
        'MetaCloud' => 'Meta Cloud API',
    ];

    protected $fillable = [
        'provider_name',
        'whatsapp_business_account_id',
        'phone_number_id',
        'access_token',
        'verify_token',
        'webhook_url',
        'sender_name',
        'api_version',
        'description',
        'status',
        'created_by_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
