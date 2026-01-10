<?php

namespace App\Livewire\Materiais;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Material;

class GerenciarMateriais extends Component
{
    #[Layout('layouts.app')]
    // Variáveis do Formulário
    public $nome;
    public $unidade_medida = 'unidade'; // Valor padrão
    public $preco_pago;
    public $quantidade_compra;
    public $estoque_atual;

    // Regras de Validação
    protected $rules = [
        'nome' => 'required|min:3',
        'unidade_medida' => 'required',
        'preco_pago' => 'required|numeric|min:0',
        'quantidade_compra' => 'required|numeric|min:0.01', // Evita divisão por zero
        'estoque_atual' => 'required|numeric',
    ];

    public function salvar()
    {
        $this->validate();

        // 1. Calcular o custo por unidade (A mágica acontece aqui)
        // Ex: Pagou R$ 10,00 em 100 gramas = R$ 0,10 por grama
        $custo_unitario = $this->preco_pago / $this->quantidade_compra;

        // 2. Criar o Material no Banco
        Material::create([
            'nome' => $this->nome,
            'unidade_medida' => $this->unidade_medida,
            'preco_pago' => $this->preco_pago,
            'quantidade_compra' => $this->quantidade_compra,
            'custo_por_unidade' => $custo_unitario,
            'estoque_atual' => $this->estoque_atual,
        ]);

        // 3. Limpar formulário e avisar
        $this->reset(['nome', 'preco_pago', 'quantidade_compra', 'estoque_atual']);
        session()->flash('message', 'Material cadastrado com sucesso!');
    }

    public function delete($id)
    {
        Material::find($id)->delete();
    }

    public function render()
    {
        // Pega todos os materiais ordenados pelos mais novos
        $materiais = Material::orderBy('created_at', 'desc')->get();

        return view('livewire.materiais.gerenciar-materiais', [
            'materiais' => $materiais
        ]);
    }
}