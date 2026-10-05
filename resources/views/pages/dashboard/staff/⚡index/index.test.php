<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('pages::dashboard.staff.index')
        ->assertStatus(200);
});
