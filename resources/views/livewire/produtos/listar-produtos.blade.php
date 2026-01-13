<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6 px-4 sm:px-0">
            <h2 class="text-2xl font-bold text-gray-800">Meus Produtos</h2>
            <a href="{{ route('produtos.criar') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Novo Produto
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 mx-4 sm:mx-0">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
            @foreach($produtos as $produto)
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $produto->nome }}</h3>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $produto->descricao ?? 'Sem descrição' }}</p>
                            </div>
                        </div>

                        <div class="mt-4 border-t border-gray-100 pt-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-400 uppercase">Custo Total</p>
                                    <p class="font-medium text-gray-600">R$ {{ number_format($produto->custo_materiais_total + $produto->custo_mao_de_obra, 2, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-400 uppercase">Margem</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        {{ $produto->margem_lucro_percentual }}%
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 bg-blue-50 rounded-md p-3 text-center">
                                <p class="text-xs text-blue-500 uppercase font-bold">Preço de Venda</p>
                                <p class="text-2xl font-extrabold text-blue-700">
                                    R$ {{ number_format($produto->preco_final, 2, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 border-t border-gray-100 pt-4">
    
    <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded mb-3 mt-3">
        <span class="text-xs font-bold text-gray-500 uppercase">Em Estoque</span>
        <span class="text-sm font-bold {{ $produto->estoque_pronto > 0 ? 'text-blue-600' : 'text-red-500' }}">
            {{ $produto->estoque_pronto }} un
        </span>
    </div>

</div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button wire:click="delete({{ $produto->id }})" 
                                    onclick="confirm('Tem certeza que deseja apagar este produto?') || event.stopImmediatePropagation()"
                                    class="text-sm text-red-500 hover:text-red-700 hover:underline">
                                Excluir
                            </button>
                            </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 px-4 sm:px-0">
            {{ $produtos->links() }}
        </div>
        
        @if($produtos->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Você ainda não tem produtos cadastrados.</p>
            </div>
        @endif

    </div>
</div>