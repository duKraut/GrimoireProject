<div>
    <ul wire:loading.remove class="divide-y divide-gray-200 dark:divide-gray-600">
        
        @forelse ($entries as $entry)
            <li wire:key="{{ $entry->id }}" class="py-3 flex items-center">
                
                @if (isset($entry->card_image_uri))
                    <img src="{{ $entry->card_image_uri }}" alt="{{ $entry->card_name }}" class="w-16 h-auto rounded-md mr-4">
                @else
                    <div class="w-16 h-24 bg-gray-300 dark:bg-gray-600 rounded-md mr-4 flex items-center justify-center">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Sem img</span>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $entry->card_name }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $entry->card_type_line }}</p>
                    
                    <div class="mt-2 flex items-center gap-2">
                        
                        <div class="mt-2 flex items-center gap-2">
                            <button 
                                wire:click="decrement({{ $entry->id }})"
                                wire:loading.attr="disabled"
                                wire:target="decrement({{ $entry->id }})"
                                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 text-lg font-bold hover:bg-gray-300 dark:hover:bg-gray-500 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $entry->quantity <= 1 ? 'disabled' : '' }}
                            >
                                -
                            </button>
                            <span class="text-lg font-semibold w-8 text-center text-gray-900 dark:text-gray-100">{{ $entry->quantity }}</span>
                            <button 
                                wire:click="increment({{ $entry->id }})"
                                wire:loading.attr="disabled"
                                wire:target="increment({{ $entry->id }})"
                                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 text-lg font-bold hover:bg-gray-300 dark:hover:bg-gray-500 flex items-center justify-center"
                            >
                                +
                            </button>
                        </div>
                    </div>
                </div>

                <button 
                    wire:click="confirmRemoval({{ $entry->id }})"
                    class="ml-4 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm self-center">
                    Remover
                </button>
            </li>
        @empty
            <li class="py-3">
                <p class="text-center text-gray-500 dark:text-gray-400">Sua coleção está vazia. Use a busca acima para adicionar cartas.</p>
            </li>
        @endforelse
    </ul>

    @if($showDeleteModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-gray-800 text-gray-100 p-6 rounded-2xl w-full max-w-md shadow-xl">
            <h2 class="text-xl font-semibold mb-3">Excluir Carta</h2>
            <p class="text-sm text-gray-300 mb-6">
                Tem certeza que deseja excluir todas as cópias desta carta? Esta ação não pode ser desfeita.
            </p>

            <div class="flex justify-end gap-3">
                <button 
                    wire:click="cancelRemoval"
                    class="px-4 py-2 rounded-full bg-gray-600 hover:bg-gray-500 text-white">
                    Cancelar
                </button>

                <button 
                    wire:click="deleteCard"
                    class="px-4 py-2 rounded-full bg-red-400 hover:bg-red-500 text-gray-900 font-medium">
                    Excluir
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="mt-6">
        {{ $entries->links() }}
    </div>
</div>