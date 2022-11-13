<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersStatisticsInMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players_statistics_in_matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_has_player_id');
            $table->unsignedBigInteger('match_id');
            $table->unsignedBigInteger('statistic_id');
            $table->integer('value')->nullable(false)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players_statistics_in_matches');
    }
}
