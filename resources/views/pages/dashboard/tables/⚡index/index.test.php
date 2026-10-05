<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.tables.index')
        ->assertStatus(200);
});
