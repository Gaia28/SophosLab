<?php

namespace App\Livewire\Vendas;

use Livewire\Component;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\ItemVenda;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.app')]
class RegistrarVenda extends Component
{
    // Dados da Venda
    public $cliente;
    
    // Controle do Carrinho
    public $produto_selecionado_id;
    public $quantidade = 1;
    public $carrinho = []; // Array para guardar os itens temporariamente

    // Totalizadores
    public $total_venda = 0;

    public function adicionarAoCarrinho()
    {
        $this->validate([
            'produto_selecionado_id' => 'required',
            'quantidade' => 'required|integer|min:1'
        ]);

        $produto = Produto::find($this->produto_selecionado_id);

        // Verifica estoque
        if ($produto->estoque_pronto < $this->quantidade) {
            $this->addError('quantidade', "Só existem {$produto->estoque_pronto} unidades deste produto em estoque.");
            return;
        }

        // Adiciona ao array do carrinho
        $this->carrinho[] = [
            'produto_id' => $produto->id,
            'nome' => $produto->nome,
            'preco' => $produto->preco_final,
            'quantidade' => $this->quantidade,
            'subtotal' => $produto->preco_final * $this->quantidade,
        ];

        $this->calcularTotal();
        $this->reset(['produto_selecionado_id', 'quantidade']);
    }

    public function removerDoCarrinho($index)
    {
        unset($this->carrinho[$index]);
        $this->carrinho = array_values($this->carrinho); // Reorganiza índices
        $this->calcularTotal();
    }

    public function calcularTotal()
    {
        $this->total_venda = 0;
        foreach($this->carrinho as $item) {
            $this->total_venda += $item['subtotal'];
        }
    }

    public function finalizarVenda()
    {
        if (empty($this->carrinho)) {
            $this->addError('carrinho', 'O carrinho está vazio.');
            return;
        }

        // Usamos Transaction para garantir que tudo salva ou nada salva
        DB::transaction(function () {
            
            // 1. Cria a Venda
            $venda = Venda::create([
                'cliente' => $this->cliente,
                'valor_total' => $this->total_venda,
                'data_venda' => now(),
            ]);

            // 2. Salva os Itens e Baixa Estoque
            foreach ($this->carrinho as $item) {
                
                // Salva o item
                ItemVenda::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $item['produto_id'],
                    'nome_produto' => $item['nome'], // <--- AQUI: Salva o nome fixo (Snapshot)
                    'quantidade' => $item['quantidade'],
                    'preco_unitario' => $item['preco'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Baixa o estoque do produto
                $produto = Produto::find($item['produto_id']);
                $produto->decrement('estoque_pronto', $item['quantidade']);
            }
        });

        session()->flash('message', 'Venda realizada com sucesso!');
        return redirect()->route('produtos.index'); // Ou para um histórico de vendas
    }

    public function render()
    {
        // Traz apenas produtos que têm estoque (opcional, mas recomendado)
        $produtos = Produto::where('estoque_pronto', '>', 0)->orderBy('nome')->get();
        
        return view('livewire.vendas.registrar-venda', [
            'produtos' => $produtos
        ]);
    }
}