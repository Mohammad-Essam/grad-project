<?php

namespace Database\Seeders;

use App\Models\training\TrainingProgram;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrainingProgram::create(
            [
            'name'=>"basic program",
            'description'=>"a placeholder for our application, it is all we have right now",
        ]
        );
    }
}
