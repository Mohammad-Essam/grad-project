<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProgramHasExercises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_has_exercises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('training_programs')->onDelete('cascade');
            $table->string('exercise_name');
            $table->foreign('exercise_name')->references('name')->on('exercises')->onDelete('cascade');
            $table->integer('sets');
            $table->integer('reps');
            $table->integer('day');
            $table->integer("order")->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_has_exercises');
    }
}
