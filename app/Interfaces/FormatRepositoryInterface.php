<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FormatRepositoryInterface
{
    /**
     * Busca todos os formatos.
     */
    public function all(): Collection;
}