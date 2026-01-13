<?php

namespace App\Livewire\Produtos;

use Livewire\Component;
use App\Models\Produto;
use App\Models\Material;
use Livewire\Attributes\Layout;

class CriarProduto extends Component
{
    #[Layout('layouts.app')]
    // Dados do Produto
    public $nome;
    public $descricao;
    public $custo_mao_de_obra = 0;
    public $margem_lucro = 100; // Padrão 100%
    public $quantidade_inicial = 1; // Novo campo, padrão 1
    
    // Lista de Materiais Disponíveis (para o Select)
    public $todosMateriais;
    
    // A Receita (Lista dinâmica)
    // Estrutura: [['material_id' => 1, 'quantidade' => 10, 'custo_unitario' => 0.05]]
    public $items = [];

    public function mount()
    {
        $this->todosMateriais = Material::orderBy('nome')->get();
        // Começa com uma linha vazia para facilitar
        $this->adicionarItem();
    }

    public function adicionarItem()
    {
        $this->items[] = [
            'material_id' => '',
            'quantidade' => 0,
            'custo_unitario' => 0, // Auxiliar para cálculo
        ];
    }

    public function removerItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindexar array
    }

    // Hook mágico: roda sempre que o array $items é modificado no front
    public function updatedItems($value, $key)
    {
        // Descobre qual linha foi alterada (ex: items.0.material_id)
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        // Se mudou o Material, buscamos o custo dele no banco
        if ($field === 'material_id' && !empty($value)) {
            $material = Material::find($value);
            if ($material) {
                $this->items[$index]['custo_unitario'] = $material->custo_por_unidade;
            }
        }
    }

    // Propriedade Computada: Calcula o Custo dos Materiais
    public function getCustoMateriaisProperty()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $qtd = (float) ($item['quantidade'] ?? 0);
            $custo = (float) ($item['custo_unitario'] ?? 0);
            $total += $qtd * $custo;
        }
        return $total;
    }

    // Propriedade Computada: Calcula Preço Final
    public function getPrecoFinalProperty()
    {
        $custoBase = $this->custoMateriais + (float) $this->custo_mao_de_obra;
        $margem = (float) $this->margem_lucro;
        
        return $custoBase + ($custoBase * ($margem / 100));
    }
public function salvar()
    {
        $this->validate([
            'nome' => 'required|min:3',
            'quantidade_inicial' => 'required|integer|min:1', // Validação
            'items.*.material_id' => 'required',
            'items.*.quantidade' => 'required|numeric|min:0.01',
        ]);

        // Verificação de Segurança (Estoque Suficiente)
        foreach ($this->items as $index => $item) {
            if (!empty($item['material_id'])) {
                $material = Material::find($item['material_id']);
                
                // Calcula o uso TOTAL (Qtd da receita * Qtd de peças produzidas)
                $usoTotal = $item['quantidade'] * $this->quantidade_inicial;

                if ($material && $material->estoque_atual < $usoTotal) {
                    $this->addError("items.{$index}.quantidade", 
                        "Falta material! Para fazer {$this->quantidade_inicial} peças, você precisa de {$usoTotal} {$material->unidade_medida}. Só tem {$material->estoque_atual}.");
                    return;
                }
            }
        }

        // 1. Criar Produto
        $produto = Produto::create([
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'custo_mao_de_obra' => $this->custo_mao_de_obra,
            'margem_lucro_percentual' => $this->margem_lucro,
            'custo_materiais_total' => $this->custoMateriais,
            'preco_final' => $this->precoFinal,
            'estoque_pronto' => $this->quantidade_inicial // <--- Salva a qtd digitada
        ]);

        // 2. Salvar Receita e Baixar Estoque
        foreach ($this->items as $item) {
            if(!empty($item['material_id'])) {
                
                // Vincula a receita (aqui salva o unitário)
                $produto->materiais()->attach($item['material_id'], [
                    'quantidade_uso' => $item['quantidade']
                ]);

                // Baixa o estoque (Multiplicando pela quantidade produzida)
                $material = Material::find($item['material_id']);
                if ($material) {
                    $usoTotal = $item['quantidade'] * $this->quantidade_inicial; // <--- Multiplicação
                    $material->estoque_atual = $material->estoque_atual - $usoTotal;
                    $material->save();
                }
            }
        }

        session()->flash('message', "Produto criado! {$this->quantidade_inicial} unidades adicionadas ao estoque.");
        return redirect()->route('produtos.index');
    }


    public function render()
    {
        return view('livewire.produtos.criar-produto');
    }
}