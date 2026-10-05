<?php

// app/Services/Ledger/LedgerSync.php
namespace App\Services\Ledger;

use App\Models\{LedgerFaction, LedgerKingdom, LedgerMonster, LedgerThreatReport};
use Illuminate\Support\Facades\DB;
use Throwable;

class LedgerSync
{
    public function __construct(protected LedgerClient $client) {}

    /** @return array<string, array{count: int, error: ?string}> */
    public function run(): array
    {
        $jobs = [
            'kingdoms'       => fn () => $this->mirror('kingdoms', LedgerKingdom::class, fn ($r) => [
                'id' => $r['id'], 'name' => $r['name'],
            ]),
            'factions'       => fn () => $this->mirror('factions', LedgerFaction::class, fn ($r) => [
                'id' => $r['id'], 'name' => $r['name'],
            ]),
            'monsters'       => fn () => $this->mirror('monsters', LedgerMonster::class, fn ($r) => [
                'id'                => $r['id'],
                'slug'              => $r['slug'],
                'name'              => $r['name'],
                'classification'    => $r['classification'] ?? null,
                'habitat'           => $r['habitat'] ?? null,
                'threat'            => $r['threat'] ?? null,
                'threat_level'      => $r['threat_level'] ?? 0,
                'status'            => $r['status'] ?? null,
                'description'       => $r['description'] ?? null,
                'ledger_kingdom_id' => $r['kingdom_id'] ?? null,
            ]),
            'threat-reports' => fn () => $this->syncThreatReports(),
        ];

        $results = [];

        foreach ($jobs as $resource => $job) {
            try {
                $results[$resource] = ['count' => $job(), 'error' => null];
                $this->record($resource, null);
            } catch (Throwable $e) {
                report($e);
                $results[$resource] = ['count' => 0, 'error' => $e->getMessage()];
                $this->record($resource, $e->getMessage());
            }
        }

        return $results;
    }

    /** Upsert every row, then delete mirror rows the ledger no longer has. */
    protected function mirror(string $resource, string $model, callable $map): int
    {
        // Fetch everything BEFORE touching the database: a failed fetch
        // throws here, so we never prune on a partial result.
        $rows = array_map($map, iterator_to_array($this->client->all($resource), false));

        DB::transaction(function () use ($model, $rows) {
            $this->upsertRows($model, $rows);
            $model::whereNotIn('id', array_column($rows, 'id'))->delete();
        });

        return count($rows);
    }

    protected function syncThreatReports(): int
    {
        $raw = iterator_to_array($this->client->all('threat-reports'), false);

        $rows = array_map(fn ($r) => [
            'id'                => $r['id'],
            'slug'              => $r['slug'],
            'report_number'     => $r['report_number'],
            'title'             => $r['title'],
            'type'              => $r['type'],
            'level'             => $r['level'],
            'level_severity'    => $r['level_severity'] ?? 0,
            'status'            => $r['status'],
            'sightings'         => $r['sightings'] ?? 0,
            'description'       => $r['description'] ?? null,
            'region_name'       => $r['region'] ?? null,
            'ledger_kingdom_id' => $r['kingdom_id'] ?? null,
        ], $raw);

        $pivot = [];
        foreach ($raw as $r) {
            foreach ($r['monsters'] ?? [] as $monster) {
                $pivot[] = [
                    'ledger_threat_report_id' => $r['id'],
                    'ledger_monster_id'       => $monster['id'],
                ];
            }
        }

        DB::transaction(function () use ($rows, $pivot) {
            $this->upsertRows(LedgerThreatReport::class, $rows);
            LedgerThreatReport::whereNotIn('id', array_column($rows, 'id'))->delete();

            // The monster list is replaced wholesale on every run.
            DB::table('ledger_threat_report_monster')->delete();
            foreach (array_chunk($pivot, 200) as $chunk) {
                DB::table('ledger_threat_report_monster')->insert($chunk);
            }
        });

        return count($rows);
    }

    protected function upsertRows(string $model, array $rows): void
    {
        if ($rows === []) {
            return;
        }

        $update = array_values(array_diff(array_keys($rows[0]), ['id']));

        foreach (array_chunk($rows, 100) as $chunk) {
            $model::upsert($chunk, ['id'], $update);
        }
    }

    protected function record(string $resource, ?string $error): void
    {
        DB::table('ledger_sync_states')->updateOrInsert(
            ['resource' => $resource],
            [
                'last_error'     => $error,
                'last_synced_at' => $error ? DB::raw('last_synced_at') : now(),
            ],
        );
    }
}