<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->boolean('is_player')->default(0);
            $table->string('nickname', 255)->nullable(true);
            $table->string('photo', 500)->nullable(true);
            $table->integer('weight')->nullable(true);
            $table->integer('height')->nullable(true);
            $table->text('description')->nullable(true);
            $table->date('birthdate')->nullable(true);
            $table->jsonb('game_positions')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_profiles');
    }
}
