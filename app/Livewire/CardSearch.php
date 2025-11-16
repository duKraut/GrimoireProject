<?php

namespace App\Livewire;

use App\Interfaces\CollectionEntryRepositoryInterface;
use App\Models\CollectionEntry;
use App\Services\ScryfallApiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CardSearch extends Component
{
    public string $searchQuery = '';

    public array $results = [];

    public string $searchTitle = '';

    public function mount()
    {
        $this->fetchRecentCards();
    }

    public function addCard(array $cardData)
    {
        $repository = app(CollectionEntryRepositoryInterface::class);
        $user = Auth::user();

        try {
            $existingEntry = CollectionEntry::where('user_id', $user->id)
                ->where('scryfall_id', $cardData['id'])
                ->first();

            $message = '';

            if ($existingEntry) {
                $existingEntry->increment('quantity');
                $message = 'Quantidade de "'.$existingEntry->card_name.'" atualizada para '.($existingEntry->quantity);

            } else {
                $details = [
                    'scryfall_id' => $cardData['id'],
                    'quantity' => 1,
                    'condition' => 'NM',
                    'is_foil' => false,
                    'card_name' => $cardData['name'],
                    'card_type_line' => $cardData['type_line'],
                    'card_image_uri' => $cardData['image_uris']['small'] ?? null,
                ];

                $repository->create($details, $user);
                $message = 'Carta adicionada: '.$cardData['name'];
            }

            $this->dispatch('card-added', $message);

        } catch (\Exception $e) {
            $this->dispatch('card-error', 'Erro ao processar a carta.');
            Log::error('Erro ao adicionar/incrementar carta: '.$e->getMessage());
        }
    }

    public function updatedSearchQuery($value)
    {
        if (strlen($value) >= 3) {
            $scryfallService = app(ScryfallApiService::class);
            $this->results = $scryfallService->searchCardsByName($value);
            $this->searchTitle = 'Resultados da Busca';
        } elseif (empty($value)) {
            $this->fetchRecentCards();
        } else {
            $this->results = [];
            $this->searchTitle = '';
        }
    }

    private function fetchRecentCards()
    {
        $scryfallService = app(ScryfallApiService::class);
        $this->searchTitle = 'Lançamentos Recentes';

        $this->results = $scryfallService->searchCardsByName(
            'q=(r:r or r:m) order:released'
        );
    }

    public function render()
    {
        return view('livewire.card-search');
    }
}
