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
        'place',
        'cost',
        'rules',
        'capacity_event',
        'capacity_per_resident',
        'frax_id',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'rules' => 'array',
    ];

    //relationships
    public function frax() :BelongsTo
    {
        return $this->belongsTo(Frax::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'community_event_user')
        ->withPivot([
            'participants_quantity'
        ])->withTimestamps();
    }
}
