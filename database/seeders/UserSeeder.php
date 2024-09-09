<?php

namespace Database\Seeders;

use App\Models\role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //generate a super Admin
        if (User::where('username', 'Super Admin')->first() == null) {
            $super_admin = [
                'username' => 'Super Admin',
                'email' => 'superadmin@nexasgaming.co.ke',
                'phone_number' => '0',
                'codm_username' => 'Super_Admin_CODM',
                'balance' => 0.00,
                'email_verified_at' => date(now()),
                'password' => bcrypt('password'),
                'role_id' => role::where('name', 'Super Admin')->first()->id,
            ];

            User::create($super_admin);
        }

        //generate a super Admin
        if (User::where('username','=', 'Admin')->first() == null) {
            $admin = [
                'username' => 'Admin',
                'email' => 'admin@nexasgaming.co.ke',
                'phone_number' => '1',
                'codm_username' => 'Admin_CODM',
                'balance' => 0.00,
                'email_verified_at' => date(now()),
                'password' => bcrypt('password'),
                'role_id' => role::where('name', 'Admin')->first()->id,
            ];

            User::create($admin);

        }
    }
}
