<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                "name" => "てすと 太郎$i",
                "email" => "testUser$i@test.com",
                "icon" => "https://placehold.jp/3d4070/ffffff/300x300.png",
            ]);
        }
    }
}
