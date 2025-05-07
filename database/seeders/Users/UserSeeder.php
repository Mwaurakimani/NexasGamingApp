<?php

    namespace Database\Seeders\Users;

    use App\Models\User;
    use App\Models\Wallet;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

    class UserSeeder extends Seeder {

        protected bool $generateUsers = false;

        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            if ($this->generateUsers){
                $this->generateUsers();
            }

            //generate a super Admin
            if (User::where('username', 'Super Admin')->first() == null) {
                $super_admin = [
                    'username'          => 'Super Admin',
                    'email'             => 'superadmin@email.com',
                    'phone_number'      => '0',
                    'balance'           => 1000.00,
                    'email_verified_at' => date(now()),
                    'password'          => bcrypt('password'),
                    'role'              => 'Super Admin',
                    'is_active'         => 'Active',
                ];

                $user = User::create($super_admin);

                $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

                $wallet->balance = 5000;

                $wallet->save();

            }

            //generate a Admin
            if (User::where('username', '=', 'Admin')->first() == null) {
                $admin = [
                    'username'          => 'Admin',
                    'email'             => 'admin@email.com',
                    'phone_number'      => '1',
                    'balance'           => 1000.00,
                    'email_verified_at' => date(now()),
                    'password'          => bcrypt('password'),
                    'role'              => 'Admin',
                    'is_active'         => 'Active',
                ];

                $user = User::create($admin);

                $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

                $wallet->balance = 5000;

                $wallet->save();
            }

            //generate User Kimani
            if (User::where('username', '=', 'Mwaurakimani')->first() == null) {
                $account = [
                    'username'          => 'Kimani',
                    'email'             => 'kimmwaus@gmail.com',
                    'phone_number'      => '0719445697',
                    'balance'           => 1000.00,
                    'email_verified_at' => date(now()),
                    'password'          => bcrypt('password'),
                    'role'              => 'Player',
                    'is_active'         => 'Active',
                ];

                $user = User::create($account);

                $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

                $wallet->balance = 5000;

                $wallet->save();
            }

            //generate User Norah
            if (User::where('username', '=', 'Norah')->first() == null) {
                $account = [
                    'username'          => 'Norah',
                    'email'             => 'Norah@gmail.com',
                    'phone_number'      => '0717607177',
                    'balance'           => 1000.00,
                    'email_verified_at' => date(now()),
                    'password'          => bcrypt('password'),
                    'role'              => 'Player',
                    'is_active'         => 'Active',
                ];

                $user = User::create($account);

                $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

                $wallet->balance = 5000;

                $wallet->save();
            }

            //generate User Moderator
            if (User::where('username', '=', 'Moderator')->first() == null) {
                $account = [
                    'username'          => 'Moderator',
                    'email'             => 'moderators@gmail.com',
                    'phone_number'      => '2',
                    'balance'           => 1000.00,
                    'email_verified_at' => date(now()),
                    'password'          => bcrypt('password'),
                    'role'              => 'Moderator',
                    'is_active'         => 'Active',
                ];

                $user = User::create($account);

                $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

                $wallet->balance = 5000;

                $wallet->save();
            }

        }

        public function generateUsers(): void
        {
            // Player accounts
            for ($i = 1 ; $i <= 40 ; $i++) {
                User::create(
                    [
                        'username'     => 'player' . $i,
                        'email'        => "player{$i}@nexus.test",
                        'phone_number' => "+25470000000{$i}",
                        'balance'      => rand(1000, 5000),
                        'password'     => Hash::make('password'),
                        'role'         => 'Player',
                        'is_active'    => true,
                    ]);
            }

        }
    }
