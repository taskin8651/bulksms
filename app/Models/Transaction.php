<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'amount',
        'balance_after',
        'description',
        'reference_id',
        'reference_type',
        'created_by_id',
    ];

    /**
     * Transaction kis user ne create kiya
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Polymorphic relation (Transaction kisi bhi model ka ho sakta hai, jaise Order, Payment, etc.)
     */
    public function reference()
    {
        return $this->morphTo(null, 'reference_type', 'reference_id');
    }
}
