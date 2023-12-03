<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CommonAreaUser extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $fillable = [
        'time',
        'date',
        'people_quantity',
        'qr_code',
        'payment_data',
        'cancelation_data',
    ];

    protected $casts = [
        'payment_data' => 'array',
        'cancelation_data' => 'array',
    ];

}
