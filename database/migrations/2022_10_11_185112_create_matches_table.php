<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id')->nullable(false);
            $table->unsignedBigInteger('home_team_id')->nullable(true);
            $table->unsignedBigInteger('visitor_team_id')->nullable(true);
            $table->string('visitor_team_name', 200)->nullable(true);
            $table->string('home_team_name', 200)->nullable(true);
            $table->integer('visitor_score')->nullable(false);
            $table->integer('home_score')->nullable(false);
            $table->dateTime('match_datetime')->nullable(false);
            $table->text('match_adress', 5000)->nullable(false);
            $table->float('match_total_cost', 8,2)->nullable(true);
            $table->float('match_field_cost', 8,2)->nullable(true);
            $table->float('match_referees_cost', 8,2)->nullable(true);
            $table->float('extra_costs', 8, 2)->nullable(true);
            $table->text('extra_costs_description', 5000)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('home_team_id')->references('id')->on('teams');
            $table->foreign('visitor_team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
