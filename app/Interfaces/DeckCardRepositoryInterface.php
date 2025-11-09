<?php

namespace App\Interfaces;

use App\Models\Deck;
use App\Models\DeckCard;
use Illuminate\Database\Eloquent\Collection;

interface DeckCardRepositoryInterface
{
    /**
     * Busca todas as cartas de um deck específico.
     */
    public function getForDeck(Deck $deck): Collection;

    /**
     * Adiciona uma nova carta a um deck.
     */
    public function addCard(Deck $deck, array $data): DeckCard;

    /**
     * Remove uma carta de um deck.
     */
    public function removeCard(int $deckCardId): bool;

    /**
     * Atualiza a quantidade de uma carta num deck.
     */
    public function updateQuantity(int $deckCardId, int $newQuantity): bool;
}