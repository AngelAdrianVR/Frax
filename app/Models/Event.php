<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'guests_quantity',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'description',
        'qr_code',
        'user_id',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    //relationships 
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
