<div>
    <input
        wire:model.live.debounce.300ms="searchQuery"
        type="text"
        placeholder="Digite o nome de uma carta..."
        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
    >

    @if (count($results) > 0)
        <div class="mt-4 bg-white dark:bg-gray-700 rounded-lg shadow-lg p-4">

            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                {{ $searchTitle }}
            </h3>

            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach (array_slice($results, 0, 10) as $card)
                    <li wire:key="{{ $card['id'] }}" class="py-3 flex items-center">
                        
                        @if (isset($card['image_uris']['small']))
                            <img src="{{ $card['image_uris']['small'] }}" alt="{{ $card['name'] }}" class="w-16 h-auto rounded-md mr-4">
                        @endif
                        
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $card['name'] }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $card['type_line'] }}</p>
                        </div>

                        <button 
                            wire:click="addCard('{{ $card['id'] }}')"
                            class="ml-4 px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm">
                            Adicionar
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    
    @elseif (strlen($searchQuery) >= 3)
        <div class="mt-4 bg-white dark:bg-gray-700 rounded-lg shadow-lg p-4">
            <p class="text-gray-500 dark:text-gray-400">Nenhuma carta encontrada para "{{ $searchQuery }}".</p>
        </div>
    @endif
</div>