<div class="pb-32 lg:pb-12 pt-6"> 
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h2 class="font-bold text-2xl text-gray-800 mb-4">Novo Produto</h2>

        <form wire:submit.prevent="salvar" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-4">
                
                <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
                    <h3 class="font-bold text-gray-700 mb-3 border-b pb-2">Dados Básicos</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" wire:model="nome" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-10">
                            @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea wire:model="descricao" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        <div class="bg-yellow-50 p-3 rounded-md border border-yellow-200">
                            <label class="block text-sm font-bold text-yellow-800">Quantas peças você produziu agora?</label>
                            <div class="flex items-center mt-1">
                                <input type="number" wire:model="quantidade_inicial" class="w-24 rounded-md border-yellow-300 shadow-sm focus:border-yellow-500 text-center font-bold" min="1">
                                <span class="ml-3 text-xs text-gray-600">
                                    O sistema vai descontar material suficiente para fazer <b><span x-text="$wire.quantidade_inicial"></span></b> unidades.
                                </span>
                            </div>
                            @error('quantidade_inicial') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-bold text-gray-700">Receita</h3>
                        <button type="button" wire:click="adicionarItem" class="text-xs bg-blue-50 text-blue-700 font-bold py-2 px-3 rounded border border-blue-100 uppercase tracking-wide">
                            + Material
                        </button>
                    </div>

                    <div class="space-y-3">
                        @foreach($items as $index => $item)
                            <div wire:key="item-field-{{ $index }}" class="bg-gray-50 p-3 rounded-lg border border-gray-200 relative">
                                
                                <button type="button" wire:click="removerItem({{ $index }})" class="absolute top-2 right-2 text-red-400 hover:text-red-600 p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div class="grid grid-cols-1 gap-2 pr-6"> 
                                    <div>
                                        <select 
                                            wire:model.live="items.{{ $index }}.material_id" 
                                            wire:change="selecionarMaterial({{ $index }})"
                                            class="w-full text-sm rounded-md border-gray-300 py-2">
                                            <option value="">Selecione o material...</option>
                                            @foreach($todosMateriais as $mat)
                                                <option value="{{ $mat->id }}">
                                                    {{ $mat->nome }} ({{ $mat->unidade_medida }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center w-1/2">
                                            <span class="text-xs text-gray-500 mr-2">Qtd:</span>
                                            <input type="number" step="0.01" wire:model.live="items.{{ $index }}.quantidade" class="w-full text-sm rounded-md border-gray-300 py-1" placeholder="0">
                                        </div>
                                        
                                        <div class="text-right w-1/2">
                                            @php
                                                // Proteção extra aqui também
                                                $subtotal = ((float)($items[$index]['custo_unitario'] ?? 0)) * ((float)($items[$index]['quantidade'] ?? 0));
                                            @endphp
                                            <span class="text-xs text-gray-500">Custo:</span>
                                            <span class="font-bold text-gray-700">R$ {{ number_format($subtotal, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @error("items.{$index}.material_id") <span class="text-red-500 text-xs block mt-1">Selecione o material</span> @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-lg shadow lg:hidden">
                    <h3 class="font-bold text-gray-700 mb-3 border-b pb-2">Custos Extras</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Mão de Obra (R$)</label>
                            <input type="number" step="0.01" wire:model.live="custo_mao_de_obra" class="mt-1 w-full rounded-md border-gray-300 py-1">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Margem (%)</label>
                            <input type="number" wire:model.live="margem_lucro" class="mt-1 w-full rounded-md border-gray-300 py-1">
                        </div>
                    </div>
                </div>

            </div>

            <div class="hidden lg:block lg:col-span-1">
                <div class="bg-blue-50 p-6 rounded-lg shadow border border-blue-100 sticky top-6">
                    <h3 class="font-bold text-blue-800 text-lg mb-4">Resumo</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Mão de Obra (R$)</label>
                        <input type="number" step="0.01" required wire:model.live="custo_mao_de_obra" class="w-full rounded-md border-blue-200">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Margem (%)</label>
                        <div class="flex items-center">
                            <input type="number" wire:model.live="margem_lucro" class="w-full rounded-md border-blue-200">
                            <span class="ml-2 text-gray-500">%</span>
                        </div>
                    </div>

                    <div class="border-t border-blue-200 my-3"></div>
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600 text-sm">Custo Total:</span>
                        <span class="font-bold text-gray-800">R$ {{ number_format($this->custoMateriais + (float) $this->custo_mao_de_obra, 2, ',', '.') }}</span>
                    </div>

                    <div class="bg-blue-600 text-white p-4 rounded-lg text-center mt-4 shadow-md">
                        <span class="block text-xs opacity-80 uppercase tracking-widest">Preço Final</span>
                        <span class="block text-3xl font-bold mt-1">
                            R$ {{ number_format($this->precoFinal, 2, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow transition duration-200">
                        Salvar Produto
                    </button>
                </div>
            </div>

            <div class="lg:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] p-4 z-50">
                <div class="flex justify-between items-center gap-4 max-w-7xl mx-auto">
                    
                    <div class="flex flex-col">
                        <span class="text-xs text-gray-500">Preço Sugerido</span>
                        <span class="text-2xl font-bold text-blue-700">
                            R$ {{ number_format($this->precoFinal, 2, ',', '.') }}
                        </span>
                        <span class="text-[10px] text-gray-400">
                            Custo: R$ {{ number_format($this->custoMateriais + (float) $this->custo_mao_de_obra, 2, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg text-sm">
                        SALVAR
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>