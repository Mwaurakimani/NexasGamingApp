<?php

    namespace Database\Seeders;

    use App\Models\Game;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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


        }
    }
