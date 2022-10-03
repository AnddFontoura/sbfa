<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $path = 'database\seeds\sql\BraziliansCities.sql'; 

        $sql = file_get_contents($path); 

        DB::unprepared($sql); 
    }
}
