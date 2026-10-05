<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::events.index')
        ->assertStatus(200);
});
