<?php

namespace App\Policies;

use App\Models\Deck;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeckPolicy
{
    use HandlesAuthorization;

    // (Ignore os outros métodos por agora)

    /**
     * Determina se o utilizador pode atualizar o deck.
     */
    public function update(User $user, Deck $deck): bool
    {
        // Só pode atualizar se o ID do utilizador for igual ao ID do dono do deck
        return $user->id === $deck->user_id;
    }

    /**
     * Determina se o utilizador pode apagar o deck.
     */
    public function delete(User $user, Deck $deck): bool
    {
        // A mesma regra: só o dono pode apagar
        return $user->id === $deck->user_id;
    }

    /**
     * Determina se o utilizador pode ver o deck.
     */
    public function view(User $user, Deck $deck): bool
    {
        // A regra é a mesma: só o dono pode ver
        return $user->id === $deck->user_id;
    }
}