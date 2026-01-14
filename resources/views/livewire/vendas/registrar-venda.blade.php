<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Nova Venda</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Adicionar Produto</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Produto</label>
                            <select wire:model="produto_selecionado_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                                <option value="">Selecione...</option>
                                @foreach($produtos as $prod)
                                    <option value="{{ $prod->id }}">
                                        {{ $prod->nome }} (Estoque: {{ $prod->estoque_pronto }}) - R$ {{ number_format($prod->preco_final, 2, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Qtd.</label>
                            <input type="number" wire:model="quantidade" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                        </div>
                    </div>

                    @error('produto_selecionado_id') <span class="text-red-500 text-sm block mt-2">Escolha um produto.</span> @enderror
                    @error('quantidade') <span class="text-red-500 text-sm block mt-2">{{ $message }}</span> @enderror

                    <button wire:click="adicionarAoCarrinho" class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow flex justify-center items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Adicionar ao Carrinho
                    </button>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <label class="block text-sm font-medium text-gray-700">Nome do Cliente (Opcional)</label>
                    <input type="text" wire:model="cliente" placeholder="Ex: Maria da Silva" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-lg shadow sticky top-6">
                    <h3 class="font-bold text-yellow-800 text-lg mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Itens da Venda
                    </h3>

                    @if(empty($carrinho))
                        <p class="text-gray-500 text-sm text-center py-4">Carrinho vazio.</p>
                    @else
                        <div class="space-y-3 mb-6">
                            @foreach($carrinho as $index => $item)
                                <div class="flex justify-between items-start border-b border-yellow-200 pb-2">
                                    <div class="text-sm">
                                        <p class="font-bold text-gray-800">{{ $item['nome'] }}</p>
                                        <p class="text-gray-600">{{ $item['quantidade'] }} x R$ {{ number_format($item['preco'], 2, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-800">R$ {{ number_format($item['subtotal'], 2, ',', '.') }}</p>
                                        <button wire:click="removerDoCarrinho({{ $index }})" class="text-xs text-red-500 hover:text-red-700 underline">remover</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex justify-between items-center text-xl font-bold text-gray-800 mt-4 border-t border-yellow-300 pt-4">
                        <span>Total:</span>
                        <span>R$ {{ number_format($total_venda, 2, ',', '.') }}</span>
                    </div>

                    <button wire:click="finalizarVenda" 
                            @if(empty($carrinho)) disabled @endif
                            class="w-full mt-6 bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-3 px-4 rounded shadow text-lg transition duration-200">
                        Finalizar Venda
                    </button>
                    
                    @error('carrinho') <span class="text-red-500 text-xs block text-center mt-2">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>
    </div>
</div>