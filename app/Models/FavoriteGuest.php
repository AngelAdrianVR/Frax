<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavoriteGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vehicle_details',
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
