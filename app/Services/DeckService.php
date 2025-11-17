<?php

namespace App\Services;

use App\Repositories\DeckRepository;

class DeckService
{
    private DeckRepository $deckRepository;

    public function __construct(DeckRepository $deckRepository)
    {
        parent::__construct($deckRepository);

        $this->deckRepository = $deckRepository;
    }

    public function index(array $data)
    {
        return $this->deckRepository->index($data);
    }
}
