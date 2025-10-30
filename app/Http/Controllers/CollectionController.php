<?php

namespace App\Http\Controllers;

use App\Services\ScryfallApiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function __construct(
        private readonly ScryfallApiService $scryfallApiService
    ) {
    }

    public function index(): View
    {
        return view('collection.index');
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'query' => 'required|string|min:3',
        ]);

        $results = $this->scryfallApiService->searchCardsByName($validated['query']);

        return response()->json($results);
    }
}