<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //0-> wating; 1-> in progress; 2 -> completed
            $table->integer('state')->default(0);
            $table->string('exercise_name');
            $table->foreign('exercise_name')->references('name')->on('exercises')->onDelete('cascade');
            $table->integer('reps');

            $table->unsignedBigInteger('player_one_id');
            $table->foreign('player_one_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('player_one_score')->default(0);

            $table->unsignedBigInteger('player_two_id')->default(0);
            // $table->foreign('player_two_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('player_two_score')->default(0);
            $table->string('winner_username')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenges');
    }
}
