<?php

namespace App\Interfaces;

use App\Models\Deck;
use App\Models\DeckCard;
use Illuminate\Database\Eloquent\Collection;

interface DeckCardRepositoryInterface
{
    public function getForDeck(Deck $deck): Collection;

    public function addCard(Deck $deck, array $data): DeckCard;

    public function removeCard(int $deckCardId): bool;

    public function updateQuantity(int $deckCardId, int $newQuantity): bool;
}
