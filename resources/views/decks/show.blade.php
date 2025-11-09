<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            A construir Deck: <span class="text-blue-500">{{ $deck->name }}</span>
            <span class="text-base text-gray-500 ml-2">({{ $deck->format->name }})</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Aqui carregamos o nosso novo componente Livewire --}}
                    {{-- E passamos o deck atual para ele --}}
                    <livewire:deck-builder :deck="$deck" />

                </div>
            </div>
        </div>
    </div>
</x-app-layout>