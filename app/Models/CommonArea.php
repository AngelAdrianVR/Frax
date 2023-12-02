<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CommonArea extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'preparation_hours',
        'hours_anticipation_booking',
        'is_multiple_reserved',
        'description',
        'notes',
        'rules',
        'policy',
        'terms',
        'features',
        'schedule',
        'frax_id',
    ];

    protected $casts = [
        'features' => 'array',
        'schedule' => 'array',
        'is_multiple_reserved' => 'boolean',
    ];

    // relationships
    public function frax(): BelongsTo
    {
        return $this->belongsTo(Frax::class);
    }

    public function users(): BelongsToMany
    {
      return $this->belongsToMany(Quote::class)
            ->withPivot([
                'time',
                'date',
                'people_quantity',
                'qr_code',
                'payment_data',
                'cancelation_data',
            ])->withTimestamps()
            ->using(Booking::class);
    }
}
