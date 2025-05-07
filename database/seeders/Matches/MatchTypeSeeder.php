<?php

    namespace Database\Seeders\Matches;

    use App\Models\MatchType;
    use Illuminate\Database\Seeder;

    class MatchTypeSeeder extends Seeder {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            if (!MatchType::where('name', '1 v 1')->first()) {
                $one_v_one = [
                    'name'        => '1 v 1',
                    'slug'        => '1-v-1',
                    'min_players' => '2',
                    'max_players' => '2',
                ];

                MatchType::create($one_v_one);
            }

            if (!MatchType::where('name', '2 v 2')->first()) {
                $one_v_one = [
                    'name'        => '2 v 2',
                    'slug'        => '2-v-2',
                    'min_players' => '4',
                    'max_players' => '4',
                ];

                MatchType::create($one_v_one);
            }
        }
    }
