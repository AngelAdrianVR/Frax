<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CommunityEventUser extends Pivot
{
    protected $table = 'community_event_user';

    public $incrementing = true;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'participants_quantity',
        'community_event_id',
        'user_id',
    ];

    //relationships
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event() :BelongsTo
    {
        return $this->belongsTo(CommunityEvent::class);
    }
}
