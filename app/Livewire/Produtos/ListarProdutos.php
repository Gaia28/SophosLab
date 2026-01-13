<?php

namespace App\Livewire\Produtos;

use Livewire\Component;
use App\Models\Produto;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class ListarProdutos extends Component
{
    
    use WithPagination;
#[Layout('layouts.app')]
    public function delete($id)
    {
        Produto::find($id)->delete();
        session()->flash('message', 'Produto removido com sucesso.');
    }

    public function render()
    {
        // Pega os produtos do mais novo para o mais antigo
        $produtos = Produto::orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.produtos.listar-produtos', [
            'produtos' => $produtos
        ]);
    }
}