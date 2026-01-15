<?php

use App\Livewire\Materiais\GerenciarMateriais;
use App\Livewire\Materiais\MaterialCreate;
use App\Livewire\Materiais\MaterialEdit;
use App\Livewire\Materiais\MaterialIndex;
use App\Livewire\Produtos\CriarProduto;
use App\Livewire\Produtos\ListarProdutos;
use App\Livewire\Vendas\RegistrarVenda;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

 Volt::route('/', 'pages.auth.login')
        ->name('login');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
Route::get('/dashboard', App\Livewire\Dashboard::class)->name('dashboard');

Route::get('/materiais', MaterialIndex::class)->name('materiais.index');
Route::get('/materiais/criar', MaterialCreate::class)->name('materiais.create');
Route::get('/materiais/{material}/editar', MaterialEdit::class)->name('materiais.edit');
    
Route::get('/produtos/criar', CriarProduto::class)->name('produtos.criar');
Route::get('/produtos', ListarProdutos::class)->name('produtos.index');

Route::get('/vendas/nova', RegistrarVenda::class)->name('vendas.create');

});
require __DIR__.'/auth.php';
