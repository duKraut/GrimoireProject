<?php

namespace App\Services;

use App\Repositories\DeckCardRepository;

class DeckCardService
{
    private DeckCardRepository $deckCardRepository;

    public function __construct(DeckCardRepository $deckCardRepository)
    {
        parent::__construct($deckCardRepository);

        $this->deckCardRepository = $deckCardRepository;
    }

    public function index(array $data)
    {
        return $this->deckCardRepository->index($data);
    }
}
