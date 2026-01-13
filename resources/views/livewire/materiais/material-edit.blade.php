<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Editar Material</h2>
                <a href="{{ route('materiais.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                    &larr; Cancelar e Voltar
                </a>
            </div>

            <form wire:submit.prevent="atualizar" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nome do Material</label>
                    <input type="text" wire:model="nome" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Fornecedor</label>
                    <input type="text" wire:model="fornecedor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                    <label class="block text-sm font-medium text-gray-700">Qtd. no Pacote (Para cálculo)</label>
                    <input type="number" step="0.01" wire:model="quantidade_compra" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Estoque Atual</label>
                    <input type="number" step="0.01" wire:model="estoque_atual" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Ajuste aqui se fez contagem manual.</p>
                </div>

                <div class="md:col-span-2 pt-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded shadow">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>