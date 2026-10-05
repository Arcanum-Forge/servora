<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.menu.index')
        ->assertStatus(200);
});
