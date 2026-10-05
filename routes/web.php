<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::landing')->name('landing');
Route::livewire('/login', 'pages::auth/login')->name('login');
Route::livewire('/menu', 'pages::menu/index')->name('menu');
Route::livewire('/menu/details', 'pages::menu/details')->name('menu.details');
Route::livewire('/events', 'pages::events/index')->name('events');
Route::livewire('/reviews', 'pages::reviews/index')->name('reviews');


Route::livewire('/dashboard', 'pages::dashboard/index')->name('dashboard');
Route::livewire('/dashboard/pos', 'pages::dashboard/pos/index')->name('pos');
Route::livewire('/dashboard/orders', 'pages::dashboard/orders/index')->name('orders');
Route::livewire('/dashboard/kitchen', 'pages::dashboard/kitchen/index')->name('kitchen');
Route::livewire('/dashboard/events', 'pages::dashboard/events/index')->name('dashboard.events');
Route::livewire('/dashboard/reviews', 'pages::dashboard/reviews/index')->name('dashboard.reviews');
Route::livewire('/dashboard/reservations', 'pages::dashboard/reservations/index')->name('reservations');
Route::livewire('/dashboard/tables', 'pages::dashboard/tables/index')->name('tables');
Route::livewire('/dashboard/guests', 'pages::dashboard/guests/index')->name('guests');
Route::livewire('/dashboard/inventory', 'pages::dashboard/inventory/index')->name('inventory');
Route::livewire('/dashboard/menu', 'pages::dashboard/menu/index')->name('dashboard.menu');
Route::livewire('/dashboard/staff', 'pages::dashboard/staff/index')->name('staff');
Route::livewire('/dashboard/reports', 'pages::dashboard/reports/index')->name('reports');
