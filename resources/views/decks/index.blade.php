<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Meus Decks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Botão para Criar Novo Deck (ainda não funcional) --}}
            <div class="mb-4">
                <a href="{{ route('decks.create') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                    Criar Novo Deck
                </a>
            </div>

            {{-- A Grelha de Decks --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- 1. Verificamos se a coleção de decks está vazia --}}
                @forelse ($decks as $deck)
                    {{-- 2. Se não estiver, mostramos um card para cada deck --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                {{ $deck->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Formato: {{ $deck->format->name }}
                            </p>
                            <p class="mt-2 text-gray-700 dark:text-gray-300">
                                {{ Str::limit($deck->description, 100) }}
                            </p>
                            <div class="mt-4 flex justify-end space-x-4">
                                <a href="{{ route('decks.edit', $deck->id) }}" class="text-sm text-yellow-500 hover:text-yellow-300">
                                    Editar
                                </a>

                                <form method="POST" action="{{ route('decks.destroy', $deck->id) }}" onsubmit="return confirm('Tem certeza que quer apagar este deck?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-300">
                                        Apagar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            Você ainda não criou nenhum deck.
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>