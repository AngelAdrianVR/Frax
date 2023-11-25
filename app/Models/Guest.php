<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'visit_date',
        'arrived_at',
        'notes',
        'qr_code',
        'vehicle_details',
        'user_id',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'arrived_at' => 'datetime',
        'vehicle_details' => 'array'
    ];
}
