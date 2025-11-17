<?php

namespace App\Interfaces;

use App\Models\Deck;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

interface DeckRepositoryInterface
{
    public function getForUser(Authenticatable $user): Collection;

    public function create(array $data, Authenticatable $user): Deck;

    public function findById(int $id): ?Deck;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
