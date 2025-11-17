<?php

namespace App\Policies;

use App\Models\Deck;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeckPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Deck $deck): bool
    {
        return $user->id === $deck->user_id;
    }

    public function delete(User $user, Deck $deck): bool
    {
        return $user->id === $deck->user_id;
    }

    public function view(User $user, Deck $deck): bool
    {
        // A regra é a mesma: só o dono pode ver
        return $user->id === $deck->user_id;
    }
}
