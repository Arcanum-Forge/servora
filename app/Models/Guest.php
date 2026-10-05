<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Guest extends Model
{
    use HasFactory;

    public const SILVER_AT = 500;
    public const GOLD_AT = 1000;

    public const SEATING = [
        'fireplace' => 'Fireplace',
        'window' => 'Window',
        'quiet_corner' => 'Quiet corner',
        'bar' => 'Bar',
    ];

    public const DIETARY = [
        'vegetarian' => 'Vegetarian',
        'vegan' => 'Vegan',
        'gluten_free' => 'Gluten-free',
        'nut_allergy' => 'Nut allergy',
    ];

    public const STYLES = [
        'quiet' => 'Quiet',
        'celebrations' => 'Celebrations',
        'family' => 'Family dining',
        'business' => 'Business',
        'romantic' => 'Romantic',
        'solo' => 'Solo',
    ];

    protected $fillable = [
        'name',
        'phone',
        'email',
        'notes',
        'loyalty_points',
        'birthday',
        'dietary',
        'seating_preference',
        'dining_style',
        'favorite_menu_item_id',
    ];

    protected $casts = [
        'birthday' => 'date',
        'dietary' => 'array',
        'loyalty_points' => 'integer',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function waitlistEntries(): HasMany
    {
        return $this->hasMany(WaitlistEntry::class);
    }

    public const POINTS_PER_VISIT = 50;
    public const POINTS_PER_DINER = 10; // per person in the party, up to POINTS_MAX_DINERS
    public const POINTS_MAX_DINERS = 6;

    public static function pointsForParty(int $partySize): int
    {
        return self::POINTS_PER_VISIT + self::POINTS_PER_DINER * min($partySize, self::POINTS_MAX_DINERS);
    }

    /**
     * Award points for a seated reservation. Safe to call more than once:
     * the conditional update only succeeds for the first caller, so a
     * reservation can never pay out twice. Returns the points awarded (0 if already paid).
     */
    public function awardPointsFor(Reservation $reservation): int
    {
        $points = self::pointsForParty($reservation->party_size);

        $claimed = Reservation::whereKey($reservation->id)
            ->where('points_awarded', 0)
            ->update(['points_awarded' => $points]);

        if (!$claimed) {
            return 0;
        }

        $this->increment('loyalty_points', $points);

        return $points;
    }

    /** Member | Silver | Gold, derived from loyalty points. */
    protected function tier(): Attribute
    {
        return Attribute::get(fn() => match (true) {
            $this->loyalty_points >= self::GOLD_AT => 'Gold',
            $this->loyalty_points >= self::SILVER_AT => 'Silver',
            default => 'Member',
        });
    }

    /** 0-100 progress toward the next tier (Gold loops every 500 pts). */
    protected function tierProgress(): Attribute
    {
        return Attribute::get(function () {
            $p = $this->loyalty_points;

            return (int) match (true) {
                $p >= self::GOLD_AT => (($p - self::GOLD_AT) % 500) / 500 * 100,
                $p >= self::SILVER_AT => ($p - self::SILVER_AT) / (self::GOLD_AT - self::SILVER_AT) * 100,
                default => $p / self::SILVER_AT * 100,
            };
        });
    }

    protected function initials(): Attribute
    {
        return Attribute::get(fn() => Str::of($this->name)
            ->explode(' ')->filter()->take(2)
            ->map(fn($w) => Str::upper(Str::substr($w, 0, 1)))->implode(''));
    }



    public function favoriteMenuItem(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'favorite_menu_item_id');
    }

    // Keeps `$guest->favorite_item` working everywhere it's displayed
    protected function favoriteItem(): Attribute
    {
        return Attribute::get(fn() => $this->favoriteMenuItem?->name);
    }
}