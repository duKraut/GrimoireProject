<?php

namespace App\Http\Controllers;

// Imports necessários
use App\Interfaces\DeckCardRepositoryInterface;
use App\Models\Deck;
use App\Models\DeckCard; // Importamos o modelo que você forneceu
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Útil para a lógica de 'board'

class DeckCardController extends Controller
{
    use AuthorizesRequests;

    /**
     * Injeta o repositório que gerencia as entradas de DeckCard.
     */
    public function __construct(
        private readonly DeckCardRepositoryInterface $deckCardRepository
    ) {}

    /**
     * Adiciona um card (ou atualiza a quantidade) a um deck.
     * * Este método lida com a lógica "Upsert":
     * - Se o card (scryfall_id) não existe no 'board' (main/side), cria a entrada.
     * - Se o card já existe, atualiza a quantidade.
     * * Rota: POST /decks/{deck}/cards
     * (ou /decks/{deck}/deck-cards)
     */
    public function store(Request $request, Deck $deck): RedirectResponse
    {
        // 1. Verificamos se o utilizador pode atualizar este deck (Segurança)
        $this->authorize('update', $deck);

        // 2. Validamos os dados com base no modelo DeckCard
        $validatedData = $request->validate([
            // Assumindo que você tem uma tabela 'cards' que armazena os dados do Scryfall
            'scryfall_id' => 'required|string|exists:cards,scryfall_id',
            'quantity' => 'required|integer|min:1',
            'board' => ['required', 'string', Rule::in(['main', 'sideboard'])], // Usando 'sideboard' como padrão de MTG
        ]);

        // 3. Usamos o repositório para adicionar ou atualizar o card no deck
        // O repositório deve conter a lógica de "upsert"
        $this->deckCardRepository->addOrUpdateCard(
            $deck,
            $validatedData
        );

        // 4. Redirecionamos de volta para a página do deck
        return redirect()->route('decks.show', $deck->id)->with('success', 'Deck atualizado com a carta!');
    }

    /**
     * Atualiza uma entrada específica de card no deck (ex: muda a quantidade).
     * * Rota: PUT/PATCH /decks/{deck}/cards/{deck_card}
     * (ou /decks/{deck}/deck-cards/{deck_card})
     */
    public function update(Request $request, Deck $deck, DeckCard $deck_card): RedirectResponse
    {
        // 1. Verificamos se o utilizador pode atualizar este deck (Segurança)
        $this->authorize('update', $deck);

        // 2. [Segurança Extra] Verificamos se o DeckCard realmente pertence ao Deck
        // (Isso pode ser automatizado com Scoped Bindings nas rotas)
        if ($deck_card->deck_id !== $deck->id) {
            abort(404);
        }

        // 3. Validamos os dados (só podemos mudar a quantidade ou o board)
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'board' => ['required', 'string', Rule::in(['main', 'sideboard'])],
        ]);

        // 4. Usamos o repositório para atualizar a entrada específica
        $this->deckCardRepository->update($deck_card->id, $validatedData);

        // 5. Redirecionamos de volta
        return redirect()->route('decks.show', $deck->id)->with('success', 'Quantidade da carta atualizada!');
    }

    /**
     * Remove uma entrada específica de card do deck.
     * * Rota: DELETE /decks/{deck}/cards/{deck_card}
     * (ou /decks/{deck}/deck-cards/{deck_card})
     */
    public function destroy(Deck $deck, DeckCard $deck_card): RedirectResponse
    {
        // 1. Verificamos se o utilizador pode atualizar este deck (Segurança)
        $this->authorize('update', $deck);

        // 2. [Segurança Extra] Verificamos a posse
        if ($deck_card->deck_id !== $deck->id) {
            abort(404);
        }

        // 3. Usamos o repositório para apagar
        $this->deckCardRepository->delete($deck_card->id);

        // 4. Redirecionamos de volta
        return redirect()->route('decks.show', $deck->id)->with('success', 'Carta removida do deck!');
    }
}
