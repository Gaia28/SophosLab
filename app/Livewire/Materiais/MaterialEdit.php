<?php

namespace App\Livewire\Materiais;

use Livewire\Component;
use App\Models\Material;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class MaterialEdit extends Component
{
    public Material $material; // O objeto material sendo editado

    // Propriedades do formulário
    public $nome;
    public $fornecedor;
    public $unidade_medida;
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

    // Carrega os dados do banco para os campos do formulário
    public function mount(Material $material)
    {
        $this->material = $material;
        
        $this->nome = $material->nome;
        $this->fornecedor = $material->fornecedor;
        $this->unidade_medida = $material->unidade_medida;
        $this->preco_pago = $material->preco_pago;
        $this->quantidade_compra = $material->quantidade_compra;
        $this->estoque_atual = $material->estoque_atual;
    }

    public function atualizar()
    {
        $this->validate();

        $custo_unitario = $this->preco_pago / $this->quantidade_compra;

        $this->material->update([
            'nome' => $this->nome,
            'fornecedor' => $this->fornecedor,
            'unidade_medida' => $this->unidade_medida,
            'preco_pago' => $this->preco_pago,
            'quantidade_compra' => $this->quantidade_compra,
            'custo_por_unidade' => $custo_unitario,
            'estoque_atual' => $this->estoque_atual,
        ]);

        session()->flash('message', 'Material atualizado com sucesso!');

        return redirect()->route('materiais.index');
    }

    public function render()
    {
        return view('livewire.materiais.material-edit');
    }
}