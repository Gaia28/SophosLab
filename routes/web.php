<?php

use App\Livewire\Materiais\GerenciarMateriais;
use App\Livewire\Materiais\MaterialCreate;
use App\Livewire\Materiais\MaterialEdit;
use App\Livewire\Materiais\MaterialIndex;
use App\Livewire\Produtos\CriarProduto;
use App\Livewire\Produtos\ListarProdutos;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Rotas de Materiais
Route::get('/materiais', MaterialIndex::class)->name('materiais.index');
Route::get('/materiais/criar', MaterialCreate::class)->name('materiais.create');
Route::get('/materiais/{material}/editar', MaterialEdit::class)->name('materiais.edit');
    
Route::get('/produtos/criar', CriarProduto::class)->name('produtos.criar');
Route::get('/produtos', ListarProdutos::class)->name('produtos.index');
require __DIR__.'/auth.php';
