<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia; 

class CommunityEvent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'date',
        'time',
        'participants',
        'description',
        'frax_id',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    //relationships
    public function frax() :BelongsTo
    {
        return $this->belongsTo(Frax::class);
    }
}
