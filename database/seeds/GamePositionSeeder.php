<?php

use App\GamePosition;
use Illuminate\Database\Seeder;

class GamePositionSeeder extends Seeder
{
    /*
        [
            'name' => '',
            'short' => '',
            'description' => '',
            'icon' => '',
        ],
    */
    protected $gamePositions = [
        [
            'name' => 'Goleiro',
            'short' => 'GK',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-success'> GK </p>",
        ],
        [
            'name' => 'Zagueiro',
            'short' => 'ZG',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info'> ZG </p>",
        ],
        [
            'name' => 'Lateral Direito',
            'short' => 'LTD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info'> LTD </p>",
        ],
        [
            'name' => 'Lateral Esquerdo',
            'short' => 'LTE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-info'> LTE </p>",
        ],
        [
            'name' => 'Ala Direito',
            'short' => 'ALD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary'> ALD </p>",
        ],
        [
            'name' => 'Ala Esquerdo',
            'short' => 'ALE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary'> ALE </p>",
        ],
        [
            'name' => 'Volante',
            'short' => 'VOL',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary'> VOL </p>",
        ],
        [
            'name' => 'Meio Campo Direito',
            'short' => 'MCD',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary'> MCD </p>",
        ],
        [
            'name' => 'Meio Campo Esquerdo',
            'short' => 'MCE',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary'> MCE </p>",
        ],
        [
            'name' => 'Meio Campo Ofensivo',
            'short' => 'MCO',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-primary'> LTD </p>",
        ],
        [
            'name' => 'Centro Avante',
            'short' => 'CA',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger'> CA </p>",
        ],
        [
            'name' => 'Ponta de Área Externo',
            'short' => 'EX',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger'> EX </p>",
        ],
        [
            'name' => 'Segundo Avançado',
            'short' => 'SA',
            'description' => null,
            'icon' => "<p class='btn btn-sm btn-danger'> SA </p>",
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->gamePositions as $gamePosition) {
            GamePosition::updateOrCreate(
                [
                    'name' => $gamePosition['name']
                ],
                $gamePosition
            );
        }
    }
}
