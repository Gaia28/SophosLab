<div class="py-6 lg:py-12">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
    <div class="mb-4">
    <input 
        wire:model.live.debounce.250ms="search" 
        type="text" 
        placeholder="Buscar material..." 
        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    >
</div>
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">Meus Materiais</h2>
            <a href="{{ route('materiais.create') }}" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-center text-white font-bold py-3 px-4 rounded shadow">
                + Novo Material
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="hidden md:block bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Material</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fornecedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Custo Unit.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($materiais as $material)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $material->nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $material->fornecedor ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                    R$ {{ number_format($material->custo_por_unidade, 4, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $material->estoque_atual > 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                                        {{ number_format($material->estoque_atual, 2, ',', '.') }} {{ $material->unidade_medida }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('materiais.edit', $material->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
        Editar
    </a>
                                    <button wire:click="delete({{ $material->id }})" 
                                            onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()"
                                            class="text-red-600 hover:text-red-900 font-bold">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t">
                {{ $materiais->links() }}
            </div>
        </div>

        <div class="md:hidden space-y-4">
            @foreach($materiais as $material)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-100">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">{{ $material->nome }}</h3>
                            <p class="text-xs text-gray-500">{{ $material->fornecedor ?? 'Sem fornecedor' }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $material->estoque_atual > 0 ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800' }}">
                            {{ number_format($material->estoque_atual, 2, ',', '.') }} {{ $material->unidade_medida }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-end mt-4">
                        <div class="text-sm">
                            <span class="block text-xs text-gray-400 uppercase">Custo Unitário</span>
                            <span class="font-mono font-medium text-gray-600">R$ {{ number_format($material->custo_por_unidade, 4, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('materiais.edit', $material->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
        Editar
    </a>
                        
                        <button wire:click="delete({{ $material->id }})" 
                                onclick="confirm('Tem certeza?') || event.stopImmediatePropagation()"
                                class="text-red-500 bg-red-50 hover:bg-red-100 px-3 py-2 rounded text-sm font-bold border border-red-100">
                            Excluir
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="py-4">
                {{ $materiais->links() }}
            </div>
        </div>

    </div>
</div>