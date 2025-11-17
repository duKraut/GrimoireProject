<?php

namespace App\Http\Repositories;

use App\Interfaces\FormatRepositoryInterface;
use App\Models\Format;
use Illuminate\Database\Eloquent\Collection;

class FormatRepository implements FormatRepositoryInterface
{
    public function all(): Collection
    {
        return Format::orderBy('name', 'asc')->get();
    }
}
