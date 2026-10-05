<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.reviews.index')
        ->assertStatus(200);
});
