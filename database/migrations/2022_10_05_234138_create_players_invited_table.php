<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersInvitedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players_invited', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_has_player_id')->nullable(false);
            $table->string('email', 500)->nullable(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('team_has_player_id')->references('id')->on('teams_has_players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players_invited');
    }
}
