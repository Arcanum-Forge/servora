<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.kitchen.index')
        ->assertStatus(200);
});
