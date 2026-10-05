<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.pos.index')
        ->assertStatus(200);
});
