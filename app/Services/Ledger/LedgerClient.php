<?php

// app/Services/Ledger/LedgerClient.php
namespace App\Services\Ledger;

use Generator;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class LedgerClient
{
    protected function http(): PendingRequest
    {
        return Http::baseUrl(rtrim(config('services.ledger.base_url'), '/'))
            ->withToken((string) config('services.ledger.api_key'))
            ->acceptJson()
            ->timeout(10)
            ->retry(2, 500, fn ($e) => $e instanceof ConnectionException
                || ($e instanceof RequestException && $e->response->serverError()));
    }

    /** Yield every row of a resource, following the cursor pagination. */
    public function all(string $resource, array $query = []): Generator
    {
        $cursor = null;

        do {
            $response = $this->http()
                ->get("/api/v1/{$resource}", array_filter([...$query, 'per_page' => 100, 'cursor' => $cursor]))
                ->throw();

            foreach ($response->json('data', []) as $row) {
                yield $row;
            }

            $cursor = $response->json('meta.next_cursor');
        } while ($cursor);
    }
}