<?php

namespace Database\Seeders;

use App\Models\role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            'Super Admin',
            'Admin',
            'Moderator',
            'Player',
            'Guest'
        ];

        foreach ($accounts as $account) {
            $role = role::where('name', $account)->first();

            if ($role == null)
                role::create(['name' => $account]);
        }
    }
}
