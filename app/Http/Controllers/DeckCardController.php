<?php

namespace App\Http\Controllers;

use App\Interfaces\DeckCardRepositoryInterface;
use App\Models\Deck;
use App\Models\DeckCard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeckCardController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly DeckCardRepositoryInterface $deckCardRepository
    ) {}

    public function store(Request $request, Deck $deck): RedirectResponse
    {
        $this->authorize('update', $deck);

        $validatedData = $request->validate([
            'scryfall_id' => 'required|string|exists:cards,scryfall_id',
            'quantity' => 'required|integer|min:1',
            'board' => ['required', 'string', Rule::in(['main', 'sideboard'])],
        ]);

        $this->deckCardRepository->addOrUpdateCard(
            $deck,
            $validatedData
        );

        return redirect()->route('decks.show', $deck->id)->with('success', 'Deck atualizado com a carta!');
    }

    public function update(Request $request, Deck $deck, DeckCard $deck_card): RedirectResponse
    {
        $this->authorize('update', $deck);

        if ($deck_card->deck_id !== $deck->id) {
            abort(404);
        }

        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'board' => ['required', 'string', Rule::in(['main', 'sideboard'])],
        ]);

        $this->deckCardRepository->update($deck_card->id, $validatedData);

        return redirect()->route('decks.show', $deck->id)->with('success', 'Quantidade da carta atualizada!');
    }

    public function destroy(Deck $deck, DeckCard $deck_card): RedirectResponse
    {
        $this->authorize('update', $deck);

        if ($deck_card->deck_id !== $deck->id) {
            abort(404);
        }

        $this->deckCardRepository->delete($deck_card->id);

        return redirect()->route('decks.show', $deck->id)->with('success', 'Carta removida do deck!');
    }
}
