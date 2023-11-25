<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Frax extends Model
{
    use HasFactory;

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

}
