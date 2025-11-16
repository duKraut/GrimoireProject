<?php

namespace App\Repositories;

use App\Interfaces\CollectionEntryRepositoryInterface;
use App\Models\CollectionEntry;
use Illuminate\Contracts\Auth\Authenticatable;

class CollectionEntryRepository implements CollectionEntryRepositoryInterface
{
    public function create(array $details, Authenticatable $user): CollectionEntry
    {
        return $user->collectionEntries()->create($details);
    }

    public function getUserEntriesPaginated(int $userId, int $perPage = 10)
    {
        return CollectionEntry::where('user_id', $userId)
            ->orderBy('card_name')
            ->paginate($perPage);
    }

    public function incrementQuantity(int $entryId)
    {
        $entry = CollectionEntry::findOrFail($entryId);
        $entry->increment('quantity');

        return $entry;
    }

    public function decrementQuantity(int $entryId)
    {
        $entry = CollectionEntry::findOrFail($entryId);

        if ($entry->quantity > 1) {
            $entry->decrement('quantity');
        }

        return $entry;
    }

    public function deleteEntry(int $entryId)
    {
        $entry = CollectionEntry::findOrFail($entryId);

        return $entry->delete();
    }
}
