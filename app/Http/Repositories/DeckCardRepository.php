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
        return $deck->deckCards()->get();
    }

    public function addCard(Deck $deck, array $data): DeckCard
    {
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
