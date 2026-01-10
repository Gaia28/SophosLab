<?php

use App\Livewire\Materiais\GerenciarMateriais;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::get('/materiais', GerenciarMateriais::class)->name('materiais');

require __DIR__.'/auth.php';
