<?php

// app/Services/Ledger/SupplyImpactSuggester.php
namespace App\Services\Ledger;

use App\Models\{Ingredient, LedgerThreatReport, SupplyImpact};

class SupplyImpactSuggester
{
    /** @return int number of new impacts created */
    public function run(): int
    {
        $created = 0;
        $matched = [];

        foreach (LedgerThreatReport::live()->with('monsters')->get() as $report) {
            $monsterIds = $report->monsters->pluck('id');

            if ($monsterIds->isEmpty()) {
                continue;
            }

            foreach (Ingredient::whereIn('ledger_monster_id', $monsterIds)->pluck('id') as $ingredientId) {
                $matched[] = "{$report->id}:{$ingredientId}";
                // firstOrCreate never touches an existing row, so a manager's
                // escalation or dismissal survives every sync.
                $impact = SupplyImpact::firstOrCreate(
                    ['ledger_threat_report_id' => $report->id, 'ingredient_id' => $ingredientId],
                    ['effect' => SupplyImpact::LIMITED],
                );

                $created += (int) $impact->wasRecentlyCreated;
            }
        }

        // Reports deleted in the ledger disappear from the mirror; drop their impacts.
        SupplyImpact::where('is_manual', false)->get()
            ->reject(fn ($i) => in_array("{$i->ledger_threat_report_id}:{$i->ingredient_id}", $matched, true))
            ->each->delete();

        return $created;
    }
}