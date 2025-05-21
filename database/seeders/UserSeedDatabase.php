<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeedDatabase extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
           "name" => "admin",
           "email" => "admin@gmail.com",
           "password" => bcrypt("admin"),
        ]);
        User::create([
            "name" => "test",
            "email" => "test@gmail.com",
            "password" => bcrypt("test"),
        ]);
    }
}
