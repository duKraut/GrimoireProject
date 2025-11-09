<?php

namespace App\Repositories;

use App\Interfaces\DeckRepositoryInterface;
use App\Models\Deck;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

class DeckRepository implements DeckRepositoryInterface
{
    public function getForUser(Authenticatable $user): Collection
    {
        return $user->decks()->latest()->get();
    }

    public function create(array $data, Authenticatable $user): Deck
    {
        return $user->decks()->create($data);
    }

    public function findById(int $id): ?Deck
    {
        return Deck::find($id);
    }

    public function update(int $id, array $data): bool
    {
        return Deck::where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return Deck::destroy($id);
    }
}