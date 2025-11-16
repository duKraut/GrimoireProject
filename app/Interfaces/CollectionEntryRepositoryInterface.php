<?php

namespace App\Interfaces;

use Illuminate\Contracts\Auth\Authenticatable;

interface CollectionEntryRepositoryInterface
{
    public function create(array $details, Authenticatable $user);

    public function getUserEntriesPaginated(int $userId, int $perPage = 10);

    public function incrementQuantity(int $entryId);

    public function decrementQuantity(int $entryId);

    public function deleteEntry(int $entryId);
}
