<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia; 

class Service extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'phone',
        'address',
        'is_internal',
        'is_active',
        'social_networks',
        'frax_id',
    ];

    protected $casts = [
        'social_networks' => 'array',
    ];

    //relationships
    public function frax() :BelongsTo
    {
        return $this->belongsTo(Frax::class);
    }
}
