<?php

namespace App\Interfaces;

use App\Models\Deck;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

interface DeckRepositoryInterface
{
    /**
     * Busca todos os decks de um utilizador específico.
     */
    public function getForUser(Authenticatable $user): Collection;

    /**
     * Cria um novo deck para um utilizador.
     */
    public function create(array $data, Authenticatable $user): Deck;

    /**
     * Encontra um deck pelo seu ID.
     */
    public function findById(int $id): ?Deck;

    /**
     * Atualiza um deck.
     */
    public function update(int $id, array $data): bool;

    /**
     * Apaga um deck.
     */
    public function delete(int $id): bool;
}