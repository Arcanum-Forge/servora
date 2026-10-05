<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'dining_hall_id',
        'guest_id',
        'dining_table_id',
        'party_size',
        'reserved_for',
        'duration_minutes',
        'status',
        'seated_at',
        'notes',
    ];

    protected $casts = [
        'status' => ReservationStatus::class,
        'reserved_for' => 'datetime',
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

    public function table(): BelongsTo
    {
        return $this->belongsTo(DiningTable::class, 'dining_table_id');
    }

    public function endsAt(): \Carbon\CarbonInterface
    {
        return $this->reserved_for->copy()->addMinutes($this->duration_minutes);
    }

    /**
     * Whether this reservation's [reserved_for, endsAt) window overlaps another.
     */
    public function overlaps(\Carbon\CarbonInterface $start, \Carbon\CarbonInterface $end): bool
    {
        return $this->reserved_for->lt($end) && $start->lt($this->endsAt());
    }

    /**
     * Derived, not stored: a confirmed reservation within 30 minutes of its
     * time reads as "arriving soon" in the UI rather than plain "confirmed".
     */
    public function isArrivingSoon(): bool
    {
        return $this->status === ReservationStatus::Confirmed
            && $this->reserved_for->isFuture()
            && now()->diffInMinutes($this->reserved_for) <= 30;
    }

    public function isLate(): bool
    {
        return $this->status === ReservationStatus::Confirmed
            && $this->reserved_for->isPast();
    }
}