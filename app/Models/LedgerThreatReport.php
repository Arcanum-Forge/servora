<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

// app/Models/LedgerThreatReport.php
class LedgerThreatReport extends Model
{
    public $incrementing = false;
    protected $guarded = [];

    /** Statuses that count as a live disruption. Adjust to taste. */
    public const LIVE_STATUSES = ['Active'];

    public function monsters(): BelongsToMany
    {
        return $this->belongsToMany(
            LedgerMonster::class,
            'ledger_threat_report_monster',
            'ledger_threat_report_id',
            'ledger_monster_id',
        );
    }

    public function scopeLive(Builder $q): Builder
    {
        return $q->whereIn('status', self::LIVE_STATUSES);
    }
}