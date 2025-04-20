<?php

    namespace Database\Seeders;

    use App\Models\User;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

    class UserSeeder extends Seeder {

        /**
         * Run the database seeds.
         */
        public function run(): void
        {

            //generate a super Admin
            if (User::where('username', 'Super Admin')->first() == null) {
                $super_admin = [
                    'username'          => 'Super Admin',
                    'email'             => 'superadmin@email.com',
                    'phone_number'      => '0',
                    'balance'           => 0.00,
                    'email_verified_at' => date(now()),
                    'password'          => bcrypt('password'),
                    'role'              => 'Super Admin',
                    'is_active'         => 1,
                ];

                User::create($super_admin);
            }

            //generate a super Admin
            if (User::where('username', '=', 'Admin')->first() == null) {
                $admin = [
                    'username'          => 'Admin',
                    'email'             => 'admin@email.com',
                    'phone_number'      => '1',
                    'balance'           => 0.00,
                    'email_verified_at' => date(now()),
                    'password'          => bcrypt('password'),
                    'role'              => 'Admin',
                    'is_active'         => 1,
                ];

                User::create($admin);
            }

            // Player accounts
            for ($i = 1 ; $i <= 40 ; $i++) {
                User::create([
                                 'username'     => 'player' . $i,
                                 'email'        => "player{$i}@nexus.test",
                                 'phone_number' => "+25470000000{$i}",
                                 'balance'      => rand(100, 1000),
                                 'password'     => Hash::make('password'),
                                 'role'         => 'Player',
                                 'is_active'    => true,
                             ]);
            }
        }
    }
