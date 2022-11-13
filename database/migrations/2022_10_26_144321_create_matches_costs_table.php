<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches_costs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id')->nullable(false);
            $table->unsignedBigInteger('match_id')->nullable(false);
            $table->float('match_total_cost', 8,2)->nullable(true);
            $table->float('match_field_cost', 8,2)->nullable(true);
            $table->float('match_referees_cost', 8,2)->nullable(true);
            $table->float('extra_costs', 8, 2)->nullable(true);
            $table->text('extra_costs_description', 10000)->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('match_id')->references('id')->on('matches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches_costs');
    }
}
