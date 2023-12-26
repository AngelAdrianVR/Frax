<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia; 

class Support extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',  
        'frax_id',
        'user_id',
    ];

    //relationships
    public function frax(): BelongsTo
    {
        return $this->belongsTo(Frax::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
