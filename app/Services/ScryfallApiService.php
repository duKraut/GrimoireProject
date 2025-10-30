<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScryfallApiService
{
    /**
     * O endereço base da API do Scryfall.
     */
    private string $baseUrl = 'https://api.scryfall.com';

    /**
     * Busca cartas na API do Scryfall pelo nome.
     *
     * @param string $name O nome (ou parte do nome) da carta a ser buscada.
     * @return array Retorna um array com os dados das cartas encontradas.
     */
    public function searchCardsByName(string $name): array
    {
        try {
            $response = Http::get("{$this->baseUrl}/cards/search", [
                'q' => $name,
            ]);

            if ($response->successful()) {
                return $response->json('data', []);
            }

            if ($response->status() === 404) {
                return [];
            }

            Log::error('Erro ao buscar cartas na API do Scryfall', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return [];

        } catch (\Exception $e) {
            Log::error('Exceção ao conectar com a API do Scryfall', ['exception' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * Busca os detalhes de uma única carta pelo seu ID do Scryfall.
     *
     * @param string $scryfallId O UUID da carta no Scryfall.
     * @return array|null Retorna os dados da carta ou null se não for encontrada.
     */
    public function findCardByScryfallId(string $scryfallId): ?array
    {
        try {
            $response = Http::get("{$this->baseUrl}/cards/{$scryfallId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Erro ao buscar carta por ID na API do Scryfall', [
                'scryfall_id' => $scryfallId,
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Exceção ao conectar com a API do Scryfall', ['exception' => $e->getMessage()]);
            return null;
        }
    }
}