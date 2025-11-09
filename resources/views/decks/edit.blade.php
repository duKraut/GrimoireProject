<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Deck: ') }} {{ $deck->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('decks.update', $deck->id) }}">
                        @csrf
                        @method('PUT') {{-- Importante para o Laravel entender que é uma atualização --}}

                        <div>
                            <x-input-label for="name" :value="__('Nome do Deck')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $deck->name)" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="format_id" :value="__('Formato')" />
                            <select name="format_id" id="format_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @foreach ($formats as $format)
                                    <option value="{{ $format->id }}" @selected(old('format_id', $deck->format_id) == $format->id)>
                                        {{ $format->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Descrição (Opcional)')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">{{ old('description', $deck->description) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Atualizar Deck') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>