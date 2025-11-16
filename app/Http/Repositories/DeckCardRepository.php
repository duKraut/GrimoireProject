<?php

namespace App\Http\Repositories;

use App\Interfaces\DeckCardRepositoryInterface;
use App\Models\Deck;
use App\Models\DeckCard;
use Illuminate\Database\Eloquent\Collection;

class DeckCardRepository implements DeckCardRepositoryInterface
{
    public function getForDeck(Deck $deck): Collection
    {
        // Usamos a relação para buscar todas as cartas do deck
        return $deck->deckCards()->get();
    }

    public function addCard(Deck $deck, array $data): DeckCard
    {
        // Usamos a relação para criar a entrada já associada ao deck
        return $deck->deckCards()->create($data);
    }

    public function removeCard(int $deckCardId): bool
    {
        return DeckCard::destroy($deckCardId);
    }

    public function updateQuantity(int $deckCardId, int $newQuantity): bool
    {
        return DeckCard::where('id', $deckCardId)->update(['quantity' => $newQuantity]);
    }
}
