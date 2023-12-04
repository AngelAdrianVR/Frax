<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FavoriteGuest extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'vehicle_details',
        'identification',
        'notes',
        'user_id',
    ];

    protected $casts = [
        'vehicle_details' => 'array'
    ];

    //relationships
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
