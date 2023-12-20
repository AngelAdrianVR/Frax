<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Maintenance extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'status',
        'response_time',
        'description',
        'location',
        'is_anonymous_report',
        'user_id',
        'finished_at',
    ];

    protected $casts = [
        'finished_at' => 'datetime',
    ];

    // relationships
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evidence()
    {
        return $this->hasMany(MaintenanceEvidence::class);
    }
}
