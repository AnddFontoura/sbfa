<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsHasPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_has_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->unsignedBigInteger('position_id')->nullable(true);
            $table->string('name', 200)->nullable(false);
            $table->string('nickname', 200)->nullable(true);
            $table->integer('number')->nullable(true);
            $table->integer('weight')->nullable(true);
            $table->integer('height')->nullable(true);
            $table->date('birthday')->nullable(true);
            $table->boolean('active')->default(1);
            $table->text('inactive_reason')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams_has_players');
    }
}
