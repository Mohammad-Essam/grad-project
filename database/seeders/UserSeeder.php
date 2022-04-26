<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create(
            ['id' => 1,
            'username' => "admin",
            'email' => 'admin@gmail.com',
            'role' => 2,
            'password' => Hash::make('admin')]);
        $admin->api_token = "admin";
        $admin->save();
        $ahmed = User::create(
            ['username' => "ahmed",
            'email' => 'ahmed@gmail.com',
            'password' => Hash::make('ahmed')],
            );
        $ahmed->api_token ="ahmed";
        $ahmed->save();
        $hady = User::create(
            ['username' => "hady",
            'email' => 'hady@gmail.com',
            'password' => Hash::make('hady')]);
        $hady->api_token ="hady";
        $hady->save();
    }
}
