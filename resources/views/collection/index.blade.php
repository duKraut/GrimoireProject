<x-app-layout>
    {{-- O seu código de <x-slot name="header">... --}}
    
    {{-- O seu código de <div class="py-12">... --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:card-search />
                </div>
            </div>
        </div>
    </div>
    {{-- Fim do seu código existente --}}


    {{-- ADICIONE ESTE BLOCO NO FINAL DO FICHEIRO --}}
    @push('scripts')
    <script>
        // Fica à escuta dos eventos que o nosso componente Livewire está a despachar
        document.addEventListener('livewire:initialized', () => {
            
            Livewire.on('card-added', (event) => {
                // event[0] vai conter a nossa mensagem "Carta adicionada com sucesso!"
                alert(event[0]); 
            });

            Livewire.on('card-error', (event) => {
                // event[0] vai conter a nossa mensagem de erro
                alert(event[0]);
            });
        });
    </script>
    @endpush

</x-app-layout>