<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// app/Models/SupplyImpact.php
class SupplyImpact extends Model
{
    public const LIMITED = 'limited';
    public const UNAVAILABLE = 'unavailable';

    protected $fillable = ['ledger_threat_report_id', 'ingredient_id', 'effect', 'note', 'dismissed_at','is_manual'];

    protected $casts = ['dismissed_at' => 'datetime'];

    public function ingredient(): BelongsTo
    {
        return $this->belongsTo(Ingredient::class);
    }

    public function threatReport(): BelongsTo
    {
        return $this->belongsTo(LedgerThreatReport::class, 'ledger_threat_report_id');
    }

    /** Not dismissed, and the report is still live. */
    public function scopeActive($q)
    {
        return $q->whereNull('dismissed_at')
            ->whereHas('threatReport', fn ($r) => $r->live());
    }

    public function scopeBlocking($q)
    {
        return $q->active()->where('effect', self::UNAVAILABLE);
    }
}