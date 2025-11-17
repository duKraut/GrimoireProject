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
    public Deck $deck;

    public string $searchQuery = '';

    public array $searchResults = [];

    public string $searchTitle = '';

    public ?string $errorMessage = null;

    public $mainDeckCards;

    public $sideboardCards;

    public function mount(Deck $deck, ScryfallApiService $scryfallService)
    {
        $this->deck = $deck;
        $this->loadDeckCards();
    }

    public function loadDeckCards()
    {
        $repository = app(DeckCardRepositoryInterface::class);
        $scryfallService = app(ScryfallApiService::class);

        $allCardsDB = $repository->getForDeck($this->deck);

        $mainDeckEntries = $allCardsDB->where('board', 'Main');
        $sideboardEntries = $allCardsDB->where('board', 'Side');

        $this->mainDeckCards = $this->enrichCards($mainDeckEntries, $scryfallService);
        $this->sideboardCards = $this->enrichCards($sideboardEntries, $scryfallService);
    }

    private function enrichCards($entries, $scryfallService)
    {
        $enrichedCards = [];
        foreach ($entries as $entry) {
            $cardDetails = $scryfallService->findCardByScryfallId($entry->scryfall_id);
            if ($cardDetails) {
                $enrichedCards[] = [
                    'entry_id' => $entry->id,
                    'quantity' => $entry->quantity,
                    'details' => $cardDetails,
                ];
            }
        }

        return $enrichedCards;
    }

    public function updatedSearchQuery($value, ScryfallApiService $scryfallService)
    {
        if (strlen($value) >= 3) {
            $this->searchResults = $scryfallService->searchCardsByName($value);
            $this->searchTitle = 'Resultados da Busca';
        } elseif (empty($value)) {
            $this->fetchRecentCards($scryfallService);
        } else {
            $this->searchResults = [];
            $this->searchTitle = '';
        }
    }

    public function addCard(string $scryfallId, string $board = 'main')
    {
        $this->errorMessage = null;

        $repository = app(DeckCardRepositoryInterface::class);

        $details = [
            'scryfall_id' => $scryfallId,
            'quantity' => 1,
            'board' => $board === 'main' ? 'Main' : 'Side',
        ];

        try {
            $repository->addCard($this->deck, $details);

            $this->loadDeckCards();

            $this->searchQuery = '';
            $this->searchResults = [];

            if (method_exists($this, 'fetchRecentCards')) {
                $this->fetchRecentCards(app(ScryfallApiService::class));
            }

        } catch (\Exception $e) {
            Log::error('Erro ao adicionar carta ao deck: '.$e->getMessage());
            $this->errorMessage = $e->getMessage();
        }
    }

    public function removeCard(int $entryId)
    {
        $repository = app(DeckCardRepositoryInterface::class);

        try {
            $repository->removeCard($entryId);

            $this->loadDeckCards();

            $this->dispatch('card-removed', 'Carta removida do deck.');

        } catch (\Exception $e) {
            Log::error('Erro ao remover carta do deck: '.$e->getMessage());
            $this->errorMessage = 'Não foi possível remover a carta.';
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
