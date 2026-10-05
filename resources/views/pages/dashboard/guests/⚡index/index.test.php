<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.guests.index')
        ->assertStatus(200);
});
