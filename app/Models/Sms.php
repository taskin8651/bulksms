<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'smss';

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
        return $this->belongsTo(SmsTemplate::class, 'template_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
