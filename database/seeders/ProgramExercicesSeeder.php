<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProgramExercicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('program_has_exercises')->insert([
        [
            'program_id'=>1,
            'exercise_name'=>'push up',
            'sets'=>3,
            'reps'=>12,
            'order'=>0,
            'day'=>1
        ],
        [
            'program_id'=>1,
            'exercise_name'=>'squat',
            'sets'=>3,
            'reps'=>15,
            'order'=>1,
            'day'=>1
        ],
        [
            'program_id'=>1,
            'exercise_name'=>'push up',
            'sets'=>3,
            'reps'=>8,
            'order'=>0,
            'day'=>3
        ],
        [
            'program_id'=>1,
            'exercise_name'=>'squat',
            'sets'=>3,
            'reps'=>10,
            'order'=>1,
            'day'=>3
        ],
        [
            'program_id'=>1,
            'exercise_name'=>'push up',
            'sets'=>3,
            'reps'=>10,
            'order'=>0,
            'day'=>5
        ],
        [
            'program_id'=>1,
            'exercise_name'=>'squat',
            'sets'=>3,
            'reps'=>12,
            'order'=>1,
            'day'=>5
        ]
        ]);
    }
}
