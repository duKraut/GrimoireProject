<?php

namespace App\Http\Resources;

use App\Models\DeckCard;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeckCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct(DeckCard $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'deck_id' => $this->resources->deck_id,
            'scryfall_id' => $this->resources->scryfall_id,
            'quantity' => $this->resources->quantity,
            'board' => $this->resources->board,
        ];
    }
}
