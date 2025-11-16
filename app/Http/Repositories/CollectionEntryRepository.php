<?php

namespace App\Http\Repositories;

use App\Interfaces\CollectionEntryRepositoryInterface;
use App\Models\CollectionEntry;
use Illuminate\Contracts\Auth\Authenticatable;

class CollectionEntryRepository implements CollectionEntryRepositoryInterface
{
    public function create(array $details, Authenticatable $user): CollectionEntry
    {
        return $user->collectionEntries()->create($details);
    }
}
