<div class="space-y-4">
    @if ($errorMessage)
        <div class="rounded-md bg-red-100 border border-red-200 text-red-700 px-4 py-2">
            {{ $errorMessage }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- COLUNA DA ESQUERDA: BUSCA DE CARTAS --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Adicionar Cartas</h3>

        {{-- Barra de Busca --}}
        <input
            wire:model.live.debounce.300ms="searchQuery"
            type="text"
            placeholder="Digite o nome de uma carta..."
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm"
        >

        {{-- Resultados da Busca --}}
        @if (count($searchResults) > 0)
            <div class="mt-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-lg p-4 h-96 overflow-y-auto">
                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $searchTitle }}</h4>
                <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach (array_slice($searchResults, 0, 15) as $card)
                        <li wire:key="search-{{ $card['id'] }}" class="py-3 flex items-center">
                            @if (isset($card['image_uris']['small']))
                                <img src="{{ $card['image_uris']['small'] }}" alt="{{ $card['name'] }}" class="w-12 h-auto rounded-md mr-3">
                            @endif
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900 dark:text-gray-100">{{ $card['name'] }}</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $card['type_line'] ?? 'Tipo não disponível' }}</p>
                            </div>
                            <button 
                                wire:click="addCard('{{ $card['id'] }}', 'main')"
                                class="ml-2 px-2 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-xs">
                                Add Main
                            </button>
                            <button 
                                wire:click="addCard('{{ $card['id'] }}', 'side')"
                                class="ml-2 px-2 py-1 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-xs">
                                Add Side
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @elseif (strlen($searchQuery) >= 3)
            <div class="mt-4 bg-gray-50 dark:bg-gray-700 rounded-lg shadow-lg p-4">
                <p class="text-gray-500 dark:text-gray-400">Nenhuma carta encontrada para "{{ $searchQuery }}".</p>
            </div>
        @endif
    </div>

    {{-- COLUNA DA DIREITA: LISTA DO DECK --}}
    <div>
        {{-- Calculamos o total de cartas no Main Deck --}}
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Cartas no Deck ({{ array_sum(array_column($mainDeckCards, 'quantity')) }} / {{ $deck->format->min_deck_size }})
        </h3>
        
        {{-- Lista do Main Deck --}}
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-lg p-4 h-64 overflow-y-auto mb-4">
            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @forelse ($mainDeckCards as $card)
                    <li wire:key="main-{{ $card['entry_id'] }}" class="py-2 flex items-center">
                        {{-- Agora mostramos o nome da carta, que está em $card['details']['name'] --}}
                        <span class="text-gray-900 dark:text-gray-100">{{ $card['quantity'] }}x {{ $card['details']['name'] }}</span>
                        
                        {{-- TODO: Adicionar botões de +/- e Apagar --}}
                        <div class="ml-auto">
                            <button class="text-sm text-red-500 hover:text-red-300">Apagar</button>
                        </div>
                    </li>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">Seu deck principal está vazio.</p>
                @endforelse
            </ul>
        </div>

        {{-- Calculamos o total de cartas no Sideboard --}}
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Sideboard ({{ array_sum(array_column($sideboardCards, 'quantity')) }} / {{ $deck->format->sideboard_size }})
        </h3>

        {{-- Lista do Sideboard --}}
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-lg p-4 h-48 overflow-y-auto">
             <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                @forelse ($sideboardCards as $card)
                    <li wire:key="side-{{ $card['entry_id'] }}" class="py-2 flex items-center">
                        <span class="text-gray-900 dark:text-gray-100">{{ $card['quantity'] }}x {{ $card['details']['name'] }}</span>
                        
                        {{-- TODO: Adicionar botões de +/- e Apagar --}}
                        <div class="ml-auto">
                            <button class="text-sm text-red-500 hover:text-red-300">Apagar</button>
                        </div>
                    </li>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">Seu sideboard está vazio.</p>
                @endforelse
            </ul>
        </div>
    </div>

    </div>
</div>