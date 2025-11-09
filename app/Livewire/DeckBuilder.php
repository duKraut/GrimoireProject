<?php

namespace App\Livewire;

// Imports necessários
use App\Interfaces\DeckCardRepositoryInterface;
use App\Models\Deck;
use App\Services\ScryfallApiService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DeckBuilder extends Component
{
    // Propriedades para o Deck e a Busca
    public Deck $deck;

    public string $searchQuery = '';

    public array $searchResults = [];

    public string $searchTitle = '';

    public ?string $errorMessage = null;

    // Propriedades para guardar as cartas do deck
    // Vamos usar a convenção de nomes do Laravel
    public $mainDeckCards;

    public $sideboardCards;

    /**
     * O método mount() é executado quando o componente é carregado.
     * Usamos para receber o deck da página.
     */
    public function mount(Deck $deck, ScryfallApiService $scryfallService)
    {
        $this->deck = $deck;
        $this->loadDeckCards();
    }

    /**
     * Busca as cartas do deck na base de dados E busca os seus detalhes na API.
     */
    public function loadDeckCards()
    {
        // Usamos app() para obter os nossos repositórios e serviços
        $repository = app(DeckCardRepositoryInterface::class);
        $scryfallService = app(ScryfallApiService::class);

        // 1. Busca os dados brutos (IDs e quantidades) do nosso banco
        $allCardsDB = $repository->getForDeck($this->deck);

        // 2. Separa as cartas
        $mainDeckEntries = $allCardsDB->where('board', 'Main');
        $sideboardEntries = $allCardsDB->where('board', 'Side');

        // 3. "Enriquece" cada carta com dados da API
        $this->mainDeckCards = $this->enrichCards($mainDeckEntries, $scryfallService);
        $this->sideboardCards = $this->enrichCards($sideboardEntries, $scryfallService);
    }

    /**
     * Função auxiliar para buscar detalhes da API para uma lista de cartas
     */
    private function enrichCards($entries, $scryfallService)
    {
        $enrichedCards = [];
        foreach ($entries as $entry) {
            $cardDetails = $scryfallService->findCardByScryfallId($entry->scryfall_id);
            if ($cardDetails) {
                $enrichedCards[] = [
                    'entry_id' => $entry->id, // ID da nossa tabela deck_cards
                    'quantity' => $entry->quantity,
                    'details' => $cardDetails, // Todos os dados da API (nome, imagem, etc.)
                ];
            }
        }

        return $enrichedCards;
    }

    /**
     * Executado sempre que a $searchQuery é atualizada.
     * Injetamos o ScryfallApiService aqui.
     */
    public function updatedSearchQuery($value, ScryfallApiService $scryfallService)
    {
        if (strlen($value) >= 3) {
            $this->searchResults = $scryfallService->searchCardsByName($value);
            $this->searchTitle = 'Resultados da Busca';
        } elseif (empty($value)) {
            $this->fetchRecentCards($scryfallService); // Mostra recentes se a busca estiver vazia
        } else {
            $this->searchResults = [];
            $this->searchTitle = '';
        }
    }

    /**
     * Adiciona a carta selecionada ao deck.
     * Injetamos o DeckCardRepositoryInterface aqui.
     */
    public function addCard(string $scryfallId, string $board = 'main')
    {
        $this->errorMessage = null;

        // 1. Usamos app() para obter o repositório, em vez de o injetar na assinatura
        $repository = app(DeckCardRepositoryInterface::class);

        // 2. Preparamos os dados, usando o $board que veio do wire:click
        //    (Agora o $board vai ser 'main' ou 'side' corretamente)
        $details = [
            'scryfall_id' => $scryfallId,
            'quantity' => 1,
            'board' => $board === 'main' ? 'Main' : 'Side',
        ];

        try {
            // 3. O repositório é usado aqui
            $repository->addCard($this->deck, $details);

            // 4. Recarrega a lista de cartas do deck (isto já estava correto)
            $this->loadDeckCards();

            // 5. Limpa a busca para uma UX melhor
            $this->searchQuery = '';
            $this->searchResults = [];

            // Recarrega os "Lançamentos Recentes" (SE VOCÊ AINDA TIVER ESTA FUNÇÃO)
            if (method_exists($this, 'fetchRecentCards')) {
                $this->fetchRecentCards(app(ScryfallApiService::class));
            }

        } catch (\Exception $e) {
            Log::error('Erro ao adicionar carta ao deck: '.$e->getMessage());
            $this->errorMessage = $e->getMessage();
        }
    }

    private function fetchRecentCards(ScryfallApiService $scryfallService)
    {
        $this->searchTitle = 'Lançamentos Recentes';
        $this->searchResults = $scryfallService->searchCardsByName(
            'q=(r:r or r:m) order:released'
        );
    }

    public function render()
    {
        return view('livewire.deck-builder');
    }
}
