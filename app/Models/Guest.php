<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'visit_date',
        'time',
        'identification',
        'arrived_at',
        'leaved_at',
        'notes',
        'qr_code',
        'vehicle_details',
        'user_id',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'arrived_at' => 'datetime',
        'leaved_at' => 'datetime',
        'vehicle_details' => 'array'
    ];

    //relationships
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
