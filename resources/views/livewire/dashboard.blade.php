<div class="py-6 pb-20"> <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-2 gap-4 mb-8">
            
            <div class="bg-blue-600 rounded-xl p-4 shadow text-white">
                <div class="text-xs opacity-75 uppercase font-bold tracking-wider">Vendas Mês</div>
                <div class="text-2xl font-bold mt-1">
                    R$ {{ number_format(floor($vendas_mes), 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 shadow border border-gray-100">
                <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Esta Semana</div>
                <div class="text-2xl font-bold text-gray-800 mt-1">
                    R$ {{ number_format(floor($vendas_semana), 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 shadow border border-gray-100">
                <div class="text-xs text-gray-500 uppercase font-bold tracking-wider">Hoje</div>
                <div class="text-xl font-bold text-green-600 mt-1">
                    R$ {{ number_format(floor($vendas_hoje), 0, ',', '.') }}
                </div>
            </div>

            <div class="bg-purple-50 rounded-xl p-4 shadow border border-purple-100">
                <div class="text-xs text-purple-600 uppercase font-bold tracking-wider">Estoque Peças</div>
                <div class="text-2xl font-bold text-purple-800 mt-1">
                    {{ $produtos_estoque }} <span class="text-sm font-normal">un</span>
                </div>
            </div>
        </div>

        <h3 class="font-bold text-gray-700 mb-3">Acesso Rápido</h3>
        <div class="grid grid-cols-2 gap-4 mb-8">
            <a href="{{ route('vendas.create') }}" class="flex items-center justify-center bg-green-600 hover:bg-green-700 text-white p-4 rounded-lg shadow font-bold text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nova Venda
            </a>

            <a href="{{ route('produtos.criar') }}" class="flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-lg shadow font-bold text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Produzir
            </a>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-gray-700">Últimas Vendas</h3>
            <a href="{{ route('vendas.index') }}" class="text-xs text-blue-600 font-bold">Ver tudo</a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            @forelse($ultimas_vendas as $venda)
                <div class="p-4 border-b border-gray-100 flex justify-between items-center last:border-0">
                    <div>
                        <div class="font-bold text-gray-800">
                            {{ $venda->cliente ?: 'Cliente Praça' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $venda->data_venda->format('d/m H:i') }} • {{ $venda->itens->count() }} itens
                        </div>
                    </div>
                    <div class="font-bold text-green-600">
                        R$ {{ number_format($venda->valor_total, 2, ',', '.') }}
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500 text-sm">
                    Nenhuma venda registrada ainda.
                </div>
            @endforelse
        </div>

    </div>
</div>