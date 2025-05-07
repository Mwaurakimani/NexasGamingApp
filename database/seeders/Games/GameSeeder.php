<?php

    namespace Database\Seeders\Games;

    use App\Models\Game;
    use Illuminate\Database\Seeder;

    class GameSeeder extends Seeder {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            if (!Game::where('name', 'Chess')->first()) {
                $chess = [
                    'name'      => 'Chess',
                    'slug'      => 'chess',
                    'category'  => 'board',
                    'is_active' => true,
                    'config'    => json_encode([])
                ];

                Game::create($chess);
            }

            if (!Game::where('name', 'Call Of Duty Mobile')->first()) {
                $chess = [
                    'name'      => 'Call Of Duty Mobile',
                    'slug'      => 'CODM',
                    'category'  => 'mobile',
                    'is_active' => true,
                    'config'    => json_encode([])
                ];

                Game::create($chess);
            }
        }
    }
