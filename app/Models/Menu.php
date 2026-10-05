<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class, 'menu_menu_item');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(AvailabilitySchedule::class);
    }

    /**
     * Draft | Scheduled | Published (Scheduled is derived: published, but every
     * schedule starts in the future).
     */
    public function displayStatus(): string
    {
        if ($this->status !== 'published') {
            return 'Draft';
        }

        $schedules = $this->schedules;

        if (
            $schedules->isNotEmpty()
            && $schedules->every(fn($s) => $s->active_from && $s->active_from->isFuture())
        ) {
            return 'Scheduled';
        }

        return 'Published';
    }

    /**
     * A published menu with no schedules is always on.
     */
    public function isLiveNow(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        return $this->schedules->isEmpty()
            || $this->schedules->contains(fn($s) => $s->isActiveAt());
    }
}