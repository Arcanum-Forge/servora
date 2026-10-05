<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.reports.index')
        ->assertStatus(200);
});
