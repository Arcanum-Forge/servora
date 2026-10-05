<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::reviews.index')
        ->assertStatus(200);
});
