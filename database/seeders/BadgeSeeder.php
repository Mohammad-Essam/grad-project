<?php

namespace Database\Seeders;

use App\Models\badges\Badge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badges')->insert([
            [
                'name'=>'it\'s all about basics',
                'description' => 'bruce lee once said:
                "I fear not the man who has practiced 10,000 kicks once, but I fear the man who has practiced one kick 10,000 times."',
                'image'=>'media/badges/brucelee.jpg',
            ],
            [
                'name'=>'small steps make difference',
                'description' => '“Each step you take reveals a new horizon. You have taken the first step today. Now, I challenge you to take another.” ~ Dan Poynter',
                'image'=>'media/badges/steps.png'
            ]

        ]);
    }
}
