<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'acredited_at',
        'payment_id',
    ];

    protected $casts = [
        'acredited_at' => 'datetime'
    ];

    //rellationships
    public function payment():BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
