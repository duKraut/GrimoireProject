<?php

namespace App\Http\Repositories;

use App\Interfaces\FormatRepositoryInterface;
use App\Models\Format;
use Illuminate\Database\Eloquent\Collection;

class FormatRepository implements FormatRepositoryInterface
{
    public function all(): Collection
    {
        // Usamos o orderBy para garantir que a lista venha por ordem alfabética
        return Format::orderBy('name', 'asc')->get();
    }
}
