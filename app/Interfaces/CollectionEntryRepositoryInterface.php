<?php

namespace App\Interfaces;

use Illuminate\Contracts\Auth\Authenticatable;

interface CollectionEntryRepositoryInterface
{
    /**
     * Adiciona uma carta à coleção de um utilizador.
     *
     * @param array $details Os dados da entrada da coleção (scryfall_id, quantity, etc.)
     * @param Authenticatable $user O utilizador autenticado
     * @return \App\Models\CollectionEntry
     */
    public function create(array $details, Authenticatable $user);

}