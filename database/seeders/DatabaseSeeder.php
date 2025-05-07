<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Games\GameSeeder;
use Database\Seeders\Users\UserSeeder;
use Database\Seeders\Matches\MatchTypeSeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(MatchTypeSeeder::class);
    }
}
