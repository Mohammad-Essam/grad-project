<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use UserHasBadge;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            ExerciseSeeder::class,
            ProgramSeeder::class,
            ProgramExercicesSeeder::class,
            BadgeSeeder::class,
            RuleSeeder::class,
            UserHasBadgeSeeder::class,
        ]);
    }
}
