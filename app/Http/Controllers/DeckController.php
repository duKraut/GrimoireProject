<?php

namespace App\Http\Controllers;

// Imports necessários
use App\Models\Deck;
use App\Interfaces\DeckRepositoryInterface;
use App\Interfaces\FormatRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class DeckController extends Controller{
    use AuthorizesRequests;

    public function __construct(

        private readonly DeckRepositoryInterface $deckRepository,

        private readonly FormatRepositoryInterface $formatRepository

    ) {

    }



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

            'formats' => $formats

        ]);

    }



    public function store(Request $request): RedirectResponse

    {

        // 1. Validamos os dados (igual a antes)

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

        // TODO: Este será o nosso próximo passo (Adicionar Cartas)

        return view('decks.show', ['deck' => $deck]);

    }



    public function edit(Deck $deck): View

    {

        // 1. Verificamos se o utilizador logado é o dono do deck (Segurança)

        $this->authorize('update', $deck);



        // 2. Buscamos todos os formatos para o dropdown

        $formats = $this->formatRepository->all();



        // 3. Retornamos a view de edição, passando o deck e os formatos

        return view('decks.edit', [

            'deck' => $deck,

            'formats' => $formats

        ]);

    }



    public function update(Request $request, Deck $deck): RedirectResponse

    {

        // 1. Verificamos se o utilizador logado é o dono do deck (Segurança)

        $this->authorize('update', $deck);



        // 2. Validamos os dados que vieram do formulário

        $validatedData = $request->validate([

            'name' => 'required|string|max:255',

            'format_id' => 'required|exists:formats,id',

            'description' => 'nullable|string',

        ]);



        // 3. Usamos o nosso repositório para atualizar o deck

        $this->deckRepository->update($deck->id, $validatedData);



        // 4. Redirecionamos o utilizador de volta para a lista de decks

        return redirect()->route('decks.index')->with('success', 'Deck atualizado com sucesso!');

    }



    public function destroy(Deck $deck): RedirectResponse

    {

        // 1. Verificamos se o utilizador logado é o dono do deck (Segurança)

        $this->authorize('delete', $deck);



        // 2. Usamos o nosso repositório para apagar

        $this->deckRepository->delete($deck->id);



        // 3. Redirecionamos o utilizador de volta para a lista de decks

        return redirect()->route('decks.index')->with('success', 'Deck apagado com sucesso!');

    }

}