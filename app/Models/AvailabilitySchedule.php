<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AvailabilitySchedule extends Model
{
    protected $fillable = [
        'menu_id',
        'days',
        'starts_at',
        'ends_at',
        'active_from',
        'active_until',
    ];

    protected $casts = [
        'days' => 'array',
        'active_from' => 'date',
        'active_until' => 'date',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function isActiveAt(?Carbon $at = null): bool
    {
        $at ??= now();
        $today = $at->toDateString();

        if ($this->active_from && $today < $this->active_from->toDateString()) {
            return false;
        }

        if ($this->active_until && $today > $this->active_until->toDateString()) {
            return false;
        }

        if (!in_array($at->dayOfWeekIso, array_map('intval', $this->days ?? []), true)) {
            return false;
        }

        $now = $at->format('H:i');
        $start = substr($this->starts_at, 0, 5);
        $end = substr($this->ends_at, 0, 5);

        return $end > $start
            ? ($now >= $start && $now < $end)
            : ($now >= $start || $now < $end); // runs past midnight
    }

    /**
     * Live | Scheduled | Off hours | Expired | Draft
     */
    public function state(): string
    {
        if ($this->menu->status !== 'published') {
            return 'Draft';
        }

        $today = now()->toDateString();

        if ($this->active_until && $today > $this->active_until->toDateString()) {
            return 'Expired';
        }

        if ($this->active_from && $today < $this->active_from->toDateString()) {
            return 'Scheduled';
        }

        return $this->isActiveAt() ? 'Live' : 'Off hours';
    }

    public function getDaysLabelAttribute(): string
    {
        $names = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];

        $days = collect($this->days ?? [])->map(fn($d) => (int) $d)->unique()->sort()->values();

        if ($days->isEmpty()) {
            return 'No days';
        }

        if ($days->count() === 7) {
            return 'Every day';
        }

        $contiguous = ($days->last() - $days->first() + 1) === $days->count();

        if ($contiguous && $days->count() >= 3) {
            return $names[$days->first()] . ' — ' . $names[$days->last()];
        }

        return $days->map(fn($d) => $names[$d])->join(', ');
    }

    public function getWindowLabelAttribute(): string
    {
        $fmt = fn($t) => Carbon::createFromFormat('H:i', substr($t, 0, 5))->format('g:i A');

        return $fmt($this->starts_at) . ' — ' . $fmt($this->ends_at);
    }

    public function getDateRangeLabelAttribute(): ?string
    {
        if (!$this->active_from && !$this->active_until) {
            return null;
        }

        return ($this->active_from?->format('M j') ?? 'Any time')
            . ' — '
            . ($this->active_until?->format('M j') ?? 'ongoing');
    }
}