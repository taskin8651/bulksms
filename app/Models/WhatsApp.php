<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsApp extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'whats_apps';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'campaign_name',
        'template_id',
        'coins_used',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'scheduled_at',
        'setup_id',
        'created_by_id',
        'is_broadcast',
        'whatsapp_setup_id',
    ];

    public const STATUS_SELECT = [
        'running'   => 'Running',
        'draft'     => 'Draft',
        'completed' => 'Completed',
        'failed'    => 'Failed',
        'scheduled' => 'Scheduled',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function template()
    {
        return $this->belongsTo(WhatsAppTemplate::class, 'template_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }

    
    public function setup()
{
    return $this->belongsTo(WhatsAppSetup::class, 'whatsapp_setup_id');
}
}
