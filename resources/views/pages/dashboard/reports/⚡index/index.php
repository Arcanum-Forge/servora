<?php

use Livewire\Component;

new class extends Component {
    public string $view = 'Sales';
    public string $period = 'Today';

    public function setView(string $view): void
    {
        $this->view = $view;
    }

    public function setPeriod(string $period): void
    {
        $this->period = $period;
    }

    public function exportReport(): void
    {
        // Report export logic will go here.
    }
};

