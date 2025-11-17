<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Coleção de Cartas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:card-search />
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700"></div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-gray-200">
                        Sua Coleção
                    </h3>
                    
                    <livewire:collection-list />
                </div>
                
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            
            Livewire.on('card-added', (event) => {
                Toastify({
                    text: event[0],
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #8750c7ff, #4c0c96ff)",
                    }
                }).showToast();
            });

            Livewire.on('card-error', (event) => {
                Toastify({
                    text: event[0],
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    style: {
                        background: "linear-gradient(to right, #ff5f6d, #ffc371)",
                    }
                }).showToast();
            });
        });
    </script>
    @endpush

</x-app-layout>