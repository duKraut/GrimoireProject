<div>
    {{-- Feedback de carregamento (bom para UX) --}}
    <div wire:loading.delay class="w-full text-center text-gray-500 dark:text-gray-400">
        Carregando coleção...
    </div>

    {{-- A lista de cartas --}}
    <ul wire:loading.remove class="divide-y divide-gray-200 dark:divide-gray-600">
        
        {{-- O @forelse que está dando erro (porque $entries não existe) --}}
        @forelse ($entries as $entry)
            {{-- 
              Isto assume que você já salvou 'card_name', 'card_image_uri', etc.
              no banco de dados, como fizemos no "Método 1".
            --}}
            <li wire:key="{{ $entry->id }}" class="py-3 flex items-center">
                
                @if (isset($entry->card_image_uri))
                    <img src="{{ $entry->card_image_uri }}" alt="{{ $entry->card_name }}" class="w-16 h-auto rounded-md mr-4">
                @else
                    {{-- Placeholder se não houver imagem --}}
                    <div class="w-16 h-24 bg-gray-300 dark:bg-gray-600 rounded-md mr-4 flex items-center justify-center">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Sem img</span>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $entry->card_name }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $entry->card_type_line }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">Quantidade: {{ $entry->quantity ?? 1 }}</p>
                </div>

                <button 
                    wire:click="removeCard({{ $entry->id }})"
                    wire:confirm="Tem certeza que deseja remover esta carta da coleção?"
                    class="ml-4 px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm">
                    Remover
                </button>
            </li>
        @empty
            {{-- Mensagem para quando a coleção estiver vazia --}}
            <li class="py-3">
                <p class="text-center text-gray-500 dark:text-gray-400">Sua coleção está vazia. Use a busca acima para adicionar cartas.</p>
            </li>
        @endforelse
    </ul>

    {{-- Links da Paginação --}}
    <div class="mt-6">
        {{ $entries->links() }}
    </div>
</div>