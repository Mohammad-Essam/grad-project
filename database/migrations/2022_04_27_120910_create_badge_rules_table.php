<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgeRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_rules', function (Blueprint $table) {
            $table->id();
            $table->string('badge_name');
            $table->foreign('badge_name')->references('name')->on('badges')->onDelete('cascade');
            $table->string('exercise_name');
            $table->foreign('exercise_name')->references('name')->on('exercises')->onDelete('cascade');
            $table->integer('count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badge_rules');
    }
}
