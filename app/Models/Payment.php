<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'limit_date',
        'paid_at',
        'bills',
        'total',
        'user_id',
    ];

    protected $casts = [
        'limit_date' => 'datetime',
        'paid_at' => 'datetime',
        'bills' => 'array',
    ];

    //relationships
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentTicket():HasOne
    {
        return $this->hasOne(PaymentTicket::class);
    }
}