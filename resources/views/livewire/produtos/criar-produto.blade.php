<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <h2 class="font-bold text-2xl text-gray-800 mb-6">Novo Produto</h2>

        <form wire:submit.prevent="salvar" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold text-gray-700 mb-4">Dados Básicos</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome do Produto</label>
                            <input type="text" wire:model="nome" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descrição (Opcional)</label>
                            <textarea wire:model="descricao" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-700">Receita (Materiais Usados)</h3>
                        <button type="button" wire:click="adicionarItem" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-800 py-1 px-3 rounded border">
                            + Adicionar Material
                        </button>
                    </div>

                    <div class="space-y-3">
                        @foreach($items as $index => $item)
    <div wire:key="item-field-{{ $index }}" class="flex items-end gap-3 bg-gray-50 p-3 rounded border border-gray-200">
                                
                                <div class="flex-grow">
                                    <label class="text-xs text-gray-500">Material</label>
                                    <select wire:model.live="items.{{ $index }}.material_id" class="w-full text-sm rounded-md border-gray-300">
                                        <option value="">Selecione...</option>
                                        @foreach($todosMateriais as $mat)
                                            <option value="{{ $mat->id }}">
                                                {{ $mat->nome }} ({{ $mat->unidade_medida }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-24">
                                    <label class="text-xs text-gray-500">Qtd.</label>
                                    <input type="number" step="0.01" wire:model.live="items.{{ $index }}.quantidade" class="w-full text-sm rounded-md border-gray-300" placeholder="0">
                                </div>

                                <div class="w-24 text-right pb-2 text-sm text-gray-600">
                                    @php
                                        $subtotal = ((float)($items[$index]['custo_unitario'] ?? 0)) * ((float)($items[$index]['quantidade'] ?? 0));
                                    @endphp
                                    R$ {{ number_format($subtotal, 2, ',', '.') }}
                                </div>

                                <button type="button" wire:click="removerItem({{ $index }})" class="text-red-500 hover:text-red-700 pb-2">
                                    &times;
                                </button>
                            </div>
                            @error("items.{$index}.material_id") <span class="text-red-500 text-xs">Selecione o material</span> @enderror
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-blue-50 p-6 rounded-lg shadow border border-blue-100 sticky top-4">
                    <h3 class="font-bold text-blue-800 text-lg mb-4">Precificação</h3>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Custo Materiais:</span>
                        <span class="font-medium">R$ {{ number_format($this->custoMateriais, 2, ',', '.') }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Custo Mão de Obra (R$)</label>
                        <input type="number" step="0.01" wire:model.live="custo_mao_de_obra" class="w-full rounded-md border-blue-200 focus:ring-blue-500">
                    </div>

                    <div class="border-t border-blue-200 my-3"></div>

                    <div class="flex justify-between items-center mb-4">
                        <span class="font-bold text-gray-700">Custo Total:</span>
                        <span class="font-bold text-gray-800">R$ {{ number_format($this->custoMateriais + $this->custo_mao_de_obra, 2, ',', '.') }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Margem de Lucro (%)</label>
                        <div class="flex items-center">
                            <input type="number" wire:model.live="margem_lucro" class="w-full rounded-md border-blue-200 focus:ring-blue-500">
                            <span class="ml-2 text-gray-500">%</span>
                        </div>
                    </div>

                    <div class="bg-blue-600 text-white p-4 rounded-lg text-center mt-6 shadow-md">
                        <span class="block text-sm opacity-80">Preço Sugerido de Venda</span>
                        <span class="block text-3xl font-bold mt-1">
                            R$ {{ number_format($this->precoFinal, 2, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-lg transition duration-200">
                        Salvar Produto
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>