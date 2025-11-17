<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FormatRepositoryInterface
{
    public function all(): Collection;
}
