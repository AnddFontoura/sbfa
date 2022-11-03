<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesHasPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches_has_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('match_id')->nullable(false);
            $table->unsignedBigInteger('team_has_player_id')->nullable(false);
            $table->unsignedBigInteger('game_position_id')->nullable(true);
            $table->integer('number_used');
            $table->boolean('present')->default(0);
            $table->float('payed', 8,2)->nullable(true);
            $table->text('match_notes',1000)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('match_id')->references('id')->on('matches');
            $table->foreign('team_has_player_id')->references('id')->on('teams_has_players');
            $table->foreign('game_position_id')->references('id')->on('game_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches_has_players');
    }
}
