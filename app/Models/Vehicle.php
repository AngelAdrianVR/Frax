<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Vehicle extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'brand',
        'plate',
        'color',
        'notes',
        'user_id',
    ];

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
