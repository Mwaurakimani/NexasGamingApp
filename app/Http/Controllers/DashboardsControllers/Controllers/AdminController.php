<?php

    namespace App\Http\Controllers\DashboardsControllers\Controllers;

    use App\Models\User;
    use App\Models\Matches;
    use Illuminate\Support\Facades\Redis;

    class AdminController {
        public static function getStats(): array
        {
            $onlineUsers = Redis::hgetall('online_users');

            return [
                ['icon' => '👥', 'label' => 'Total Users', 'value' => User::all()->count()],
                ['icon' => '🛠️', 'label' => 'Active Users', 'value' => count($onlineUsers)],
                ['icon' => '🎮', 'label' => 'Live Matches', 'value' => Matches::all()->count()],
                ['icon' => '⚠️', 'label' => 'Open Disputes', 'value' => '-'],
            ];
        }

        public function getUsers()
        {

        }

        public function getToggles()
        {

        }

        public function getLogs()
        {

        }

        public function getNotices()
        {

        }
    }
