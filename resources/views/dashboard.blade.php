<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tela inicial') }}
        </h2>
    </x-slot>
    
    <div class="mt-12 max-w-7xl mx-auto sm:px-6 lg:px-8 col-span-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            Escolha uma das telas:
            <div class="mt-6 flex space-x-10">
                <button 
                    onclick="window.location.href='{{ route('collection.index') }}'" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Ir para a Coleção
                </button>
                <button 
                    onclick="window.location.href='{{ route('decks.index') }}'" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Ir para a Criação de Decks
                </button>
            </div>
        </div>
    </div>
</x-app-layout>