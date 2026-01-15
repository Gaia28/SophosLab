<?php

namespace App\Livewire\Vendas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Venda;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class VendasIndex extends Component
{
    use WithPagination;

    public function render()
    {
        // Pega as vendas com os itens (para contar qtd) ordenadas por data
        $vendas = Venda::with('itens')
            ->latest('data_venda')
            ->paginate(20); // 20 por página

        return view('livewire.vendas.vendas-index', [
            'vendas' => $vendas
        ]);
    }
}