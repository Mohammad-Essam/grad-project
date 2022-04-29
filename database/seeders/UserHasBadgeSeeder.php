<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserHasBadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_has_badges')->insert([
            [
                'badge_name' => 'small steps make difference',
                'user_id' => 1,
                'status' => 0,
            ],
            [
                'badge_name' => 'it\'s all about basics',
                'user_id' => 1,
                'status' => 0,
            ],
            
        ]);
    }
}
