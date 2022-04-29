<?php

namespace Database\Seeders;

use App\Models\badges\BadgeRule;
use Illuminate\Database\Seeder;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BadgeRule::insert([
            [
                'badge_name' => 'small steps make difference',
                'exercise_name' => 'push up',
                'count' => 8,
            ],
            [
                'badge_name' => 'it\'s all about basics',
                'exercise_name' => 'push up',
                'count' => 100,
            ],
            [
                'badge_name' => 'it\'s all about basics',
                'exercise_name' => 'squat',
                'count' => 100,
            ]
        ]);
    }
}
