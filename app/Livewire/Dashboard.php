<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Venda;
use App\Models\Produto;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public $vendas_hoje;
    public $vendas_semana;
    public $vendas_mes;
    public $produtos_estoque;
    public $ultimas_vendas;

    public function mount()
    {
        $agora = Carbon::now();

       $this->vendas_hoje = Venda::whereBetween('data_venda', [
            $agora->copy()->startOfDay(), 
            $agora->copy()->endOfDay()
        ])->sum('valor_total');
        
      $inicioSemana = $agora->copy()->startOfWeek(Carbon::SUNDAY);
        $fimSemana    = $agora->copy()->endOfWeek(Carbon::SATURDAY);

        $this->vendas_semana = Venda::whereBetween('data_venda', [
            $inicioSemana, 
            $fimSemana
        ])->sum('valor_total');
        // 3. Vendas do Mês
        $this->vendas_mes = Venda::whereMonth('data_venda', $agora->month)
            ->whereYear('data_venda', $agora->year)
            ->sum('valor_total');

        // 4. Estoque Total (Soma da quantidade de peças prontas)
        $this->produtos_estoque = Produto::sum('estoque_pronto');

        // 5. Lista rápida das últimas 5 vendas
        $this->ultimas_vendas = Venda::with('itens')
            ->latest('data_venda')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}