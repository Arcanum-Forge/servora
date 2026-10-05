<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.reservations.index')
        ->assertStatus(200);
});
