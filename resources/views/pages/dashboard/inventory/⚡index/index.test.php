<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.inventory.index')
        ->assertStatus(200);
});
