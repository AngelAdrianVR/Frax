<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'time',
        'type_access',
        'arrived_at',
        'leaved_at',
        'qr_code',
        'notes',
        'guest_reference_id',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'arrived_at' => 'datetime',
        'leaved_at' => 'datetime',
    ];

    //relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
