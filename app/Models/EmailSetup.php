<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSetup extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'email_setups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const PROVIDER_NAME_SELECT = [
        'Hostinger' => 'Hostinger',
        'Gmail'     => 'Gmail',
        'SendGrid'  => 'SendGrid',
    ];

    protected $fillable = [
        'provider_name',
        'from_name',
        'from_email',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'ip_address',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
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
