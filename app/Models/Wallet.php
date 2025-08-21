<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'wallets';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'balance',
        'status',
        'created_by_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const STATUS_SELECT = [
        'active'   => 'Active',
        'inactive' => 'Inactive',
        'pending'  => 'Pending',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // Wallet owner (created_by_id)
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
