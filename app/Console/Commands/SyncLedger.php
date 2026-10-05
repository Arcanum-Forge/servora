<?php

// app/Console/Commands/SyncLedger.php
namespace App\Console\Commands;

use App\Services\Ledger\LedgerSync;
use Illuminate\Console\Command;

class SyncLedger extends Command
{
    protected $signature = 'ledger:sync';
    protected $description = 'Mirror monsters, threat reports, kingdoms and factions from the ledger';

    public function handle(LedgerSync $sync): int
    {
        $results = $sync->run();

        foreach ($results as $resource => $r) {
            $r['error']
                ? $this->error("{$resource}: failed. {$r['error']}")
                : $this->info("{$resource}: {$r['count']} synced");
        }

        return collect($results)->contains(fn ($r) => $r['error']) ? self::FAILURE : self::SUCCESS;
    }
}