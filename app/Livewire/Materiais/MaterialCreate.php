<?php

namespace App\Livewire\Materiais;

use Livewire\Component;
use App\Models\Material;
use Livewire\Attributes\Layout;

class MaterialCreate extends Component
{
        #[Layout('layouts.app')]

    public $nome;
    public $fornecedor; // Novo campo
    public $unidade_medida = 'unidade';
    public $preco_pago;
    public $quantidade_compra;
    public $estoque_atual;

    protected $rules = [
        'nome' => 'required|min:3',
        'fornecedor' => 'nullable|string|max:255',
        'unidade_medida' => 'required',
        'preco_pago' => 'required|numeric|min:0',
        'quantidade_compra' => 'required|numeric|min:0.01',
        'estoque_atual' => 'required|numeric',
    ];

    public function salvar()
    {
        $this->validate();

        $custo_unitario = $this->preco_pago / $this->quantidade_compra;

        Material::create([
            'nome' => $this->nome,
            'fornecedor' => $this->fornecedor,
            'unidade_medida' => $this->unidade_medida,
            'preco_pago' => $this->preco_pago,
            'quantidade_compra' => $this->quantidade_compra,
            'custo_por_unidade' => $custo_unitario,
            'estoque_atual' => $this->estoque_atual,
        ]);

        session()->flash('message', 'Material cadastrado com sucesso!');
        
        // Redireciona para a lista após salvar
        return redirect()->route('materiais.index');
    }

    public function render()
    {
        return view('livewire.materiais.material-create');
    }
}