<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'contacts';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'active'  => 'Active',
        'blocked' => 'Blocked',
    ];

  

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'whatsapp_number',
        'status',
        'organization',
        'created_at',
        'updated_at',
        'deleted_at',
        'organizer_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function organizer()
{
    return $this->belongsTo(Organizer::class, 'organizer_id');
}

}
