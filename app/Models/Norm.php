<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Norm extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'frax_id',
    ];

    //relationships
    public function frax(): BelongsTo
    {
        return $this->belongsTo(Frax::class);
    }
}
