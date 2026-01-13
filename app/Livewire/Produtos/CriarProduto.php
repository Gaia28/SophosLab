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
            'items.*.material_id' => 'required',
            'items.*.quantidade' => 'required|numeric|min:0.01',
        ]);

        // Verificação de Segurança (Opcional):
        // Checa se tem estoque suficiente antes de salvar. 
        // Se quiser permitir estoque negativo, pode remover este bloco foreach.
        foreach ($this->items as $index => $item) {
            if (!empty($item['material_id'])) {
                $material = Material::find($item['material_id']);
                if ($material && $material->estoque_atual < $item['quantidade']) {
                    $this->addError("items.{$index}.quantidade", "Estoque insuficiente! Você só tem {$material->estoque_atual} {$material->unidade_medida}.");
                    return; // Para tudo e avisa o erro
                }
            }
        }

        // --- INÍCIO DA CRIAÇÃO ---
        
        // 1. Criar o Produto
        // Definimos 'estoque_pronto' como 1, pois assumimos que você acabou de fabricar a peça.
        $produto = Produto::create([
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'custo_mao_de_obra' => $this->custo_mao_de_obra,
            'margem_lucro_percentual' => $this->margem_lucro,
            'custo_materiais_total' => $this->custoMateriais,
            'preco_final' => $this->precoFinal,
            'estoque_pronto' => 1 
        ]);

        // 2. Salvar a Receita E Baixar o Estoque
        foreach ($this->items as $item) {
            if(!empty($item['material_id'])) {
                
                // A. Vincula na tabela pivô (salva a receita)
                $produto->materiais()->attach($item['material_id'], [
                    'quantidade_uso' => $item['quantidade']
                ]);

                // B. Baixa o estoque do Material
                $material = Material::find($item['material_id']);
                if ($material) {
                    $material->estoque_atual = $material->estoque_atual - $item['quantidade'];
                    $material->save();
                }
            }
        }

        // 3. Resetar e Redirecionar
        session()->flash('message', 'Produto criado e materiais descontados do estoque!');
        return redirect()->route('produtos.index');
    }

    public function render()
    {
        return view('livewire.produtos.criar-produto');
    }
}