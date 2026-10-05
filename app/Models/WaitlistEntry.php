<?php

namespace App\Models;

use App\Enums\WaitlistStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaitlistEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'dining_hall_id',
        'guest_id',
        'party_size',
        'status',
        'joined_at',
        'seated_at',
    ];

    protected $casts = [
        'status' => WaitlistStatus::class,
        'joined_at' => 'datetime',
        'seated_at' => 'datetime',
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(DiningHall::class, 'dining_hall_id');
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function waitedMinutes(): int
    {
        return (int) floor(abs($this->joined_at->diffInMinutes(now())));
    }
}