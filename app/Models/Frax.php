<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Frax extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'admin_name',
        'email',
        'number_houses',
        'frax_properties',
    ];

    protected $casts = [
        'frax_properties' => 'array',
    ];

    //relationships
    public function users() :HasMany
    {
        return $this->hasMany(User::class);
    }


    public function communityEvents() :HasMany
    {
        return $this->hasMany(CommunityEvent::class);
    }

}
