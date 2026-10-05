<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.orders.index')
        ->assertStatus(200);
});
