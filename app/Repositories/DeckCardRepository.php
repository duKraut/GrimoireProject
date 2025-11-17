<?php

namespace App\Repositories;

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
        $deck->loadMissing('format');

        $copyLimit = (int) ($deck->format->copy_limit ?? 0);
        $quantityToAdd = $data['quantity'] ?? 1;

        $existingEntry = $deck->deckCards()
            ->where('scryfall_id', $data['scryfall_id'])
            ->where('board', $data['board'])
            ->first();

        if ($existingEntry) {
            if ($copyLimit > 0 && $existingEntry->quantity >= $copyLimit) {
                throw new \RuntimeException(__('Limite de cópias atingido para este card neste formato.'));
            }

            $newQuantity = $existingEntry->quantity + $quantityToAdd;

            if ($copyLimit > 0 && $newQuantity > $copyLimit) {
                $newQuantity = $copyLimit;
            }

            $existingEntry->update(['quantity' => $newQuantity]);

            return $existingEntry->refresh();
        }

        if ($copyLimit > 0 && $quantityToAdd > $copyLimit) {
            $data['quantity'] = $copyLimit;
        }

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
