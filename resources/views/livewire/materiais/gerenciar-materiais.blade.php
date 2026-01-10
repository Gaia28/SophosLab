<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Novo Material</h3>
                    
                    <form wire:submit.prevent="salvar" class="space-y-4">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome do Material</label>
                            <input type="text" wire:model="nome" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ex: Miçanga Azul">
                            @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unidade de Medida</label>
                            <select wire:model="unidade_medida" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="unidade">Unidade (peça)</option>
                                <option value="gramas">Gramas (peso)</option>
                                <option value="metros">Metros (comprimento)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Valor Pago (R$)</label>
                            <input type="number" step="0.01" wire:model="preco_pago" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Qtd. no Pacote</label>
                            <input type="number" step="0.01" wire:model="quantidade_compra" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Ex: 500 se for gramas.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estoque Atual</label>
                            <input type="number" step="0.01" wire:model="estoque_atual" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                                Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Estoque Disponível</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Unit.</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($materiais as $material)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $material->nome }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            R$ {{ number_format($material->custo_por_unidade, 4, ',', '.') }} <span class="text-xs text-gray-400">/{{ $material->unidade_medida }}</span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $material->estoque_atual > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ number_format($material->estoque_atual, 2, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                            <button wire:click="delete({{ $material->id }})" 
                                                    onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()"
                                                    class="text-red-600 hover:text-red-900">
                                                Excluir
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($materiais->isEmpty())
                            <div class="text-center py-10 text-gray-500">
                                Nenhum material cadastrado ainda.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>