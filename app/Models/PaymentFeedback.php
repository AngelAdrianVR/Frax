<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia; 

class PaymentFeedback extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'feddback_type',
        'description',
        'answer_contact',
        'urgency_level',
        'user_id'
    ];

    //relatinships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
