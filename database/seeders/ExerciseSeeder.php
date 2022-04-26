<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\training\Exercise;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Exercise::create(
            [
            'name'=>"push up",
            'video'=>"media/exercises/pushup.mp4",
            'exp'=>10,
            'description'=>'it works more than one muscle in the same time'
            ]);
        Exercise::create(
        [
            'name'=>"squat",
            'video'=>"media/exercises/squat.mp4",
            'exp'=>5,
        ]
        );
    }
}
