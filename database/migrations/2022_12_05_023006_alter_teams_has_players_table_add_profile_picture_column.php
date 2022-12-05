<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTeamsHasPlayersTableAddProfilePictureColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('teams_has_players', function (Blueprint $table) {
            $table->string('profile_picture', 500)
                ->nullable(true)
                ->after('position_id');

            $table->foreign('position_id')->references('id')->on('game_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('teams_has_players', function(Blueprint $table) {
            $table->dropColumn('profile_picture');

            $table->dropForeign('teams_has_players_position_id_foreign');
        });
    }
}
