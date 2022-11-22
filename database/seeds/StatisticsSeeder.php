<?php

use App\Statistic;
use Illuminate\Database\Seeder;

class StatisticsSeeder extends Seeder
{
    /*
    
        [
            'name' => '',
            'description' => '',
        ],

     */
    protected $statistics = [
        [
            'name' => 'Gols Sofridos',
            'description' => 'Quantidade de gols sofridos pelo goleiro',
        ],
        [
            'name' => 'Defesas Difíceis',
            'description' => 'Defesa dificil é toda aquela que exige do goleiro um certo preparo ou movimentação inesperada.',
        ],
        [
            'name' => 'Escanteios',
            'description' => 'Quantidade de escanteios que esse jogador cobrou',
        ],
        [
            'name' => 'Passes Perdidos',
            'description' => 'Passes que o jogador tentou executar mas acabou mudando a posse da bola para o time adversário',
        ],
        [
            'name' => 'Passes Completos',
            'description' => 'Quantidade de passes que chegaram a um jogador do mesmo time sem interferência e sem perda da posse de bola',
        ],
        [
            'name' => 'Desarmes',
            'description' => 'Quantidade de vezes que o jogador retirou a bola de um adversário e o time manteve a posse da bola na sequencia',
        ],
        [
            'name' => 'Faltas Recebidas',
            'description' => 'Faltas que o jogador recebeu',
        ],
        [
            'name' => 'Faltas Cometidas',
            'description' => 'Faltas cometidas pelo jogador',
        ],
        [
            'name' => 'Cartões Amarelos',
            'description' => 'Quantidade de cartões amarelos recebidos na partida por um jogador',
        ],
        [
            'name' => 'Cartões Vermelhos',
            'description' => 'Quantidade de cartões vermelhos recebidos na partida por um jogador',
        ],
        [
            'name' => 'Chutes a gol',
            'description' => 'Qualquer chute a gol que não resulte num gol, ultrapasse a linha de fundo, acerte o goleiro ou a trave',
        ],
        [
            'name' => 'Chutes bem sucedidos',
            'description' => 'São considerados bem sucedidos chutes que batem na trave ou no goleiro',
        ],
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->statistics as $statistic) {
            Statistic::updateOrCreate(
                [
                    'name' => $statistic['name']
                ],
                $statistic
            );
        }
    }
}
