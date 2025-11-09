<?php

namespace App\Livewire;

use App\Interfaces\CollectionEntryRepositoryInterface;
use App\Services\ScryfallApiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CardSearch extends Component
{
    public string $searchQuery = '';
    public array $results = [];
    public string $searchTitle = ''; // Propriedade para guardar o título (ex: "Lançamentos Recentes")

    /**
     * O método mount() é executado UMA VEZ, quando o componente é carregado.
     * É o local perfeito para buscar os nossos dados iniciais.
     */
    public function mount()
    {
        $this->fetchRecentCards();
    }

    /**
     * Adiciona a carta à coleção.
     */
    public function addCard(string $scryfallId)
    {
        $repository = app(CollectionEntryRepositoryInterface::class);
        $user = Auth::user();

        $details = [
            'scryfall_id' => $scryfallId,
            'quantity' => 1,
            'condition' => 'NM',
            'is_foil' => false,
        ];

        try {
            $repository->create($details, $user);
            $this->dispatch('card-added', 'Carta adicionada com sucesso!');

        } catch (\Exception $e) {
            $this->dispatch('card-error', 'Erro ao adicionar a carta.');
            Log::error('Erro ao adicionar carta à coleção: ' . $e->getMessage());
        }
    }

    /**
     * Executado sempre que a propriedade $searchQuery é atualizada.
     */
    public function updatedSearchQuery($value)
    {
        // 1. Se o utilizador digitar 3+ caracteres, fazemos a busca dele
        if (strlen($value) >= 3) {
            $scryfallService = app(ScryfallApiService::class);
            $this->results = $scryfallService->searchCardsByName($value);
            $this->searchTitle = 'Resultados da Busca';
        } 
        // 2. Se ele apagar a busca (string vazia), mostramos os recentes novamente
        elseif (empty($value)) { 
            $this->fetchRecentCards();
        }
        // 3. Se tiver entre 1-2 caracteres, limpamos os resultados e não mostramos nada
        else {
            $this->results = [];
            $this->searchTitle = '';
        }
    }

    /**
     * Busca as cartas mais recentes para o estado inicial.
     * Criámos um método separado para isto para o podermos reutilizar.
     */
    private function fetchRecentCards()
    {
        // Usamos app() para obter o serviço
        $scryfallService = app(ScryfallApiService::class);
        $this->searchTitle = 'Lançamentos Recentes';
        
        // Esta é uma query especial do Scryfall:
        // 'r:r or r:m' -> Raridade rara ou mítica
        // 'order:released' -> Ordenar pela data de lançamento (mais novas primeiro)
        $this->results = $scryfallService->searchCardsByName(
            'q=(r:r or r:m) order:released'
        );
    }

    public function render()
    {
        return view('livewire.card-search');
    }
}