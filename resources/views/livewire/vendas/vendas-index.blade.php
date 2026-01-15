<div class="py-6 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Histórico de Vendas</h2>
            
            <a href="{{ route('vendas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @php
            $ultima_semana = null;
        @endphp

        <div class="space-y-4">
            @forelse($vendas as $venda)
                
                @php
                    // Lógica para agrupar: Pega o número da semana e ano
                    $semana_atual = $venda->data_venda->format('W-Y');
                    
                    // Calcula as datas de início e fim daquela semana para exibir bonito
                    $inicio = $venda->data_venda->copy()->startOfWeek(\Carbon\Carbon::SUNDAY)->format('d/m');
                    $fim = $venda->data_venda->copy()->endOfWeek(\Carbon\Carbon::SATURDAY)->format('d/m');
                @endphp

                {{-- SE A SEMANA MUDOU, MOSTRA O CABEÇALHO --}}
                @if($ultima_semana !== $semana_atual)
                    <div class="relative py-2 mt-6 mb-2">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-gray-100 px-3 text-sm font-semibold text-gray-500 rounded-full">
                                Semana de {{ $inicio }} a {{ $fim }}
                            </span>
                        </div>
                    </div>
                    @php $ultima_semana = $semana_atual; @endphp
                @endif

                {{-- CARD DA VENDA --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 flex justify-between items-center">
                    
                    <div>
                        <div class="text-gray-900 font-bold">
                            {{ $venda->cliente ?: 'Cliente Balcão' }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $venda->data_venda->format('d/m \à\s H:i') }}
                            
                            <span class="mx-2">•</span>
                            
                            <span>{{ $venda->itens->count() }} itens</span>
                        </div>
                        
                        <div class="text-xs text-gray-400 mt-1 truncate w-48">
                            {{ $venda->itens->pluck('nome_produto')->join(', ') }}
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-lg font-bold text-green-600">
                            R$ {{ number_format(floor($venda->valor_total), 0, ',', '.') }}
                        </div>
                        <button class="text-gray-400 hover:text-blue-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                </div>

            @empty
                <div class="text-center py-10 text-gray-500">
                    Nenhuma venda registrada.
                </div>
            @endforelse

            <div class="mt-4">
                {{ $vendas->links() }}
            </div>
        </div>
    </div>
</div>