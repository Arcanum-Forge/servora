<?php

use Livewire\Component;

new class extends Component {
    public string $status = 'All';

    public string $station = 'All Stations';

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setStation(string $station): void
    {
        $this->station = $station;
    }

    public function startTicket(int $id): void
    {
        // Update ticket status to preparing.
    }

    public function markReady(int $id): void
    {
        // Update ticket status to ready.
    }

    public function completeTicket(int $id): void
    {
        // Update ticket status to completed.
    }
};