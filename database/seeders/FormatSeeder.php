<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::disableForeignKeyConstraints();

        DB::table('formats')->truncate();

        Schema::enableForeignKeyConstraints();

        $formats = [

            [
                'name' => 'Standart',
                'description' => 'Formato um contra um com 60 cards no mínimo para o deck principal (até 15 no deck reserva). O vencedor é determinado por eliminatória simples ou melhor de três jogos, com cada jogador tendo 20 de vida. Esses jogos devem ter a duração padrão de um jogo (por volta de 20 minutos).',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 15,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'both'
            ],

            [
                'name' => 'Pioneer',
                'description' => 'Este formato não rotaciona e contempla coleções a partir de Retorno a Ravnica. Ele pretende ser mais forte que o Padrão, mas menos poderoso que Moderno ou Legado. Decks construídos pode ter até quatro cópias de cada card, somando deck e reserva. Terrenos básicos não estão incluindo nesta restrição.',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 15,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'both'
            ],

            [
                'name' => 'Modern',
                'description' => 'Formato um contra um com 60 cards no mínimo para o deck principal (até 15 no deck reserva). Jogos de Moderno têm a duração média de um jogo (cerca de 20 minutos).',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 15,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'both'
            ],

            [
                'name' => 'Legacy',
                'description' => 'Como um formato construído, o Legado não rotaciona e permite cards de todas as coleções de Magic (com exceção daqueles na lista de cards banidos). Seu deck e reserva não podem possuir mais de quatro cópias de um card neste formato, exceto os terrenos básicos.',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 15,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'both'
            ],

            [
                'name' => 'Commander',
                'description' => 'Este formato está pensado para quatro jogadores e os decks são de 99 cards + 1 card de comandante. A duração da partida neste formato é de cerca de 20 minutos por jogador.
                A base do formato Commander é escolher seu herói e construir um deck em torno dele. Nesse formato informal multijogador, você escolhe uma criatura lendária para servir como comandante e constrói o resto do deck em torno da identidade de cor dela e de habilidades únicas. Os jogadores só podem usar um exemplar de cada card em seu deck, com exceção dos terrenos básicos, mas podem usar cards de toda a história de Magic.',
                'min_deck_size' => 100,
                'max_deck_size' => 100,
                'sideboard_size' => 0,
                'copy_limit' => 1,
                'is_singleton' => true,
                'platform' => 'fisical'
            ],

            [
                'name' => 'Vintage',
                'description' => 'Este formato permite que sejam usados cards de todas as coleções de Magic e inclui cards de expansões e coleções especiais (com exceção dos cards na lista de banidos)! Este formato tem uma lista de cards restritos que limita o uso de um card a uma única cópia no deck ou na reserva. Vintage é um formato construído que não permite que o deck e a reserva juntos tenham mais de quatro cópias do mesmo card.',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 15,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'both'
            ],

            [
                'name' => 'Pauper',
                'description' => 'todos os cards precisam ter sido lançados na raridade comum em uma coleção ou produto de Magic. Os cards promocionais comuns só são válidos se o card atender ao requisito.
                Se uma versão comum de um card em particular tiver sido lançada em produtos de papel de Magic: The Gathering ou no Magic: The Gathering Online, qualquer versão daquele card será válida neste formato. Isso inclui cards de terrenos que foram impressos com o símbolo da coleção comum e o código de raridade L.',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 15,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'both'
            ],

            [
                'name' => 'Oathbreaker',
                'description' => 'Oathbreaker é um formato multijogador em que os jogadores constroem seus decks em torno de seus Planeswalkers favoritos. Cada deck consiste em 60 cards, distribuídos da seguinte forma:
                1 Oathbreaker (um card de Planeswalker), 1 Mágica Característica (um card de mágica instantânea ou feitiço), 58 cards do deck principal. Todos os cards no deck, incluindo a Mágica Característica, devem ser da mesma identidade de cor do Oathbreaker. Com exceção dos terrenos básicos, os jogadores só podem possuir uma cópia de cada card em seu deck. São permitidos cards de todas as coleções da história de Magic.',
                'min_deck_size' => 60,
                'max_deck_size' => 60,
                'sideboard_size' => 0,
                'copy_limit' => 1,
                'is_singleton' => true,
                'platform' => 'fisical'
            ],

            [
                'name' => 'Brawl (Brawl Padrão)',
                'description' => 'Um desafio para a construção de decks, Brawl é uma mistura de Padrão e Commander. Neste formato, você usará cards válidos no Padrão para construir um deck no estilo Commander, em torno de uma criatura Lendária ou de um Planeswalker. Você pode jogar 1x1 no MTG Arena.',
                'min_deck_size' => 60,
                'max_deck_size' => 60,
                'sideboard_size' => 0,
                'copy_limit' => 1,
                'is_singleton' => true,
                'platform' => 'both'
            ],

            [
                'name' => 'Brawl Histórico',
                'description' => 'Sistema variante de Brawl jogada no MTG Arena que permite o uso de todas as cartas disponíveis no formato Histórico, em vez de apenas as cartas válidas no Padrão',
                'min_deck_size' => 100,
                'max_deck_size' => 100,
                'sideboard_size' => 0,
                'copy_limit' => 1,
                'is_singleton' => true,
                'platform' => 'digital'
            ],

            [
                'name' => 'Commander Duel (1v1',
                'description' => 'Este formato está pensado para quatro jogadores e os decks são de 99 cards + 1 card de comandante. A duração da partida neste formato é de cerca de 20 minutos por jogador.
                A base do formato Commander é escolher seu herói e construir um deck em torno dele. Nesse formato de duelo, você escolhe uma criatura lendária para servir como comandante e constrói o resto do deck em torno da identidade de cor dela e de habilidades únicas. Os jogadores só podem usar um exemplar de cada card em seu deck, com exceção dos terrenos básicos, mas podem usar cards de toda a história de Magic.',
                'min_deck_size' => 100,
                'max_deck_size' => 100,
                'sideboard_size' => 0,
                'copy_limit' => 1,
                'is_singleton' => true,
                'platform' => 'fisical'
            ],

            [
                'name' => 'Pauper Commander',
                'description' => 'Pauper Commander é uma variante de Commander . Possui duas diferenças distintas, além da lista de banimentos. Primeiramente, as regras do seu comandante mudam. Seu comandante precisa ser uma criatura incomum , mas não precisa ser uma criatura incomum lendária.
                Seu deck deve ser construído com cartas comuns . Cartas que receberam pelo menos uma impressão comum são válidas. A legalidade do formato considera apenas lançamentos no MTGO e no papel; cartas lançadas como comuns na Arena não são válidas.',
                'min_deck_size' => 100,
                'max_deck_size' => 100,
                'sideboard_size' => 0,
                'copy_limit' => 1,
                'is_singleton' => true,
                'platform' => 'fisical'
            ],

            [
                'name' => 'Histórico',
                'description' => 'Histórico é o maior formato Construído de MTG Arena, repleto de cards novos e antigos de Magic. Cards exclusivos do digital são válidos neste formato, incluindo versões rebalanceadas de cards já existentes. Jogue estratégias únicas, sinergias selvagens e construa decks únicos! Histórico nunca rotaciona e é curado como um formato com prioridade para o digital.',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 7,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'both'
            ],

            [
                'name' => 'Timeless',
                'description' => 'Atemporal é o maior formato Construído do MTG Arena, em que todos os cards são válidos. Ele inclui os cards mais poderosos da história de Magic. Este formato usa uma lista de cards restritos que limita o uso de um card a uma única cópia no deck ou na reserva.
                Atemporal é um formato construído que não permite que o deck e a reserva juntos tenham mais de quatro cópias do mesmo card.',
                'min_deck_size' => 60,
                'max_deck_size' => null,
                'sideboard_size' => 7,
                'copy_limit' => 4,
                'is_singleton' => false,
                'platform' => 'digital'
            ]

            ];

        DB::table('formats')->insert($formats);
    }
}
