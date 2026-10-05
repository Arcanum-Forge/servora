<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::menu.index')
        ->assertStatus(200);
});
