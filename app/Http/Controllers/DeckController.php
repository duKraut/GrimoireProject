<?php

namespace App\Http\Controllers;

use App\Interfaces\DeckRepositoryInterface;
use App\Interfaces\FormatRepositoryInterface;
use App\Models\Deck;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DeckController extends Controller
{
    use AuthorizesRequests;

    public function __construct(

        private readonly DeckRepositoryInterface $deckRepository,

        private readonly FormatRepositoryInterface $formatRepository

    ) {}

    public function index(): View
    {

        $decks = $this->deckRepository->getForUser(Auth::user());

        return view('decks.index', [
            'decks' => $decks,
        ]);

    }

    public function create(): View
    {

        $formats = $this->formatRepository->all();

        return view('decks.create', [

            'formats' => $formats,

        ]);

    }

    public function store(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([

            'name' => 'required|string|max:255',

            'format_id' => 'required|exists:formats,id',

            'description' => 'nullable|string',

        ]);

        $newDeck = $this->deckRepository->create($validatedData, Auth::user());

        return redirect()->route('decks.show', $newDeck->id)->with('success', 'Deck criado! Agora, adicione as suas cartas.');

    }

    public function show(Deck $deck): View
    {
        return view('decks.show', ['deck' => $deck]);
    }

    public function edit(Deck $deck): View
    {

        $this->authorize('update', $deck);

        $formats = $this->formatRepository->all();

        return view('decks.edit', [

            'deck' => $deck,

            'formats' => $formats,

        ]);

    }

    public function update(Request $request, Deck $deck): RedirectResponse
    {

        $this->authorize('update', $deck);

        $validatedData = $request->validate([

            'name' => 'required|string|max:255',

            'format_id' => 'required|exists:formats,id',

            'description' => 'nullable|string',

        ]);

        $this->deckRepository->update($deck->id, $validatedData);

        return redirect()->route('decks.index')->with('success', 'Deck atualizado com sucesso!');

    }

    public function destroy(Deck $deck): RedirectResponse
    {

        $this->authorize('delete', $deck);

        $this->deckRepository->delete($deck->id);

        return redirect()->route('decks.index')->with('success', 'Deck apagado com sucesso!');

    }
}
