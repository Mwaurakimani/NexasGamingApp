<?php

    namespace App\Http\Controllers\DashboardControllerExtension;

    use Inertia\Inertia;
    use App\Models\User;
    use App\Models\Matches;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\DashboardsControllers\Controllers\AdminController;

    trait DashboardControllerTraits {
        private string $view = 'Dashboard';

        public function LoadView(array $data): \Inertia\Response
        {
            return Inertia::render($this->view, $data);
        }

        public function GuestPlayerDashboard(): \Inertia\Response
        {
            $user = Auth::user();

            $getWinRate = function () use ($user) {

                $totalPlayed = $user
                    ->matches()
                    ->where('status', 'completed')
                    ->count();

                $totalWon = Matches::where('winner_id', $user->id)
                                   ->where('status', 'completed')
                                   ->count();

                return $totalPlayed ? round($totalWon / $totalPlayed * 100) : 0;
            };

            $getRecentMatches = function () use ($user) {

                // Get the latest 5 matches the user participated in
                $recentMatches = $user
                    ->matches()
                    ->orderBy('matches.updated_at', 'desc')
                    ->limit(5)
                    ->get();

                // Format them
                return $recentMatches->map(function ($match) {
                    return [
                        'id'     => $match->id,
                        'game'   => $match->game->name ?? 'Unknown Game', // assuming relation game()
                        'result' => $match->winner_id === Auth::id() ? 'Win' : 'Loss',
                        'stake'  => $match->stake,
                        'status' => $match->winner_id === null ? '⏳' : ($match->winner_id === Auth::id() ? '✅' : '❌'),
                    ];
                })->toArray();
            };


            return $this->LoadView(
                [
                    "stats"         => [
                        [
                            'label' => 'Wallet Balance',
                            'icon'  => '💰',
                            'value' => 'KES ' . Auth::user()->wallet->balance
                        ],
                        [
                            'label' => 'Games Played',
                            'icon'  => '🎮',
                            'value' => optional(Auth::user()->matches()->where('status', 'completed'))->count() ?? 0,
                        ],
                        [
                            'label' => 'Win Rate',
                            'icon'  => '📈',
                            'value' => $getWinRate() . '%',
                        ],
                        [
                            'label' => 'Rank',
                            'icon'  => '🏆',
                            //TODO::CONSIDER ADDING RANKS!!
                            'value' => 'Bronze I',
                        ],
                    ],
                    "recentMatches" => $getRecentMatches(),
                    "announcements" => [
                        '🎉 Weekend Tournament begins Friday at 6 PM',
                        '💰 Double XP event live until Sunday',
                        '⚠ System maintenance scheduled for Monday 2 AM',
                    ]
                ]
            );
        }

        public function ModeratorDashboard(): \Inertia\Response
        {
            return $this->LoadView([

                                   ]);
        }

        public function AdminDashboard(): \Inertia\Response
        {
            $stats = AdminController::getStats();

            $users = function ($limit = 5) {
                return User::orderBy('created_at', 'desc')
                           ->limit($limit)
                           ->get()
                           ->map(function ($user) {
                               return [
                                   'id' => $user->id,
                                   'name' => $user->username,
                                   'balance' => $user->wallet->balance,
                                   'role' => $user->role ?? 'Guest', // default role if not set
                                   'status' => $user->status ?? 'Active', // default status if not set
                               ];
                           })
                           ->toArray();
            };

            $toggles = [
                ['feature' => 'Staking System', 'enabled' => true],
                ['feature' => 'Tournament Hosting', 'enabled' => true],
                ['feature' => 'Live Chat', 'enabled' => false],
            ];

            $logs = [
                '👑 Promoted Lina to Moderator',
                '🚫 Suspended user Bob for violation',
                '✅ Enabled staking platform',
            ];

            $notices = [
                '⚠ Some moderators haven’t responded to disputes in 24+ hrs.',
                '📌 Confirm all players before new tournament launch.',
            ];

            return $this->LoadView([
                                       'dataset' => [
                                           'stats'   => $stats,
                                           'users'   => $users(),
                                           'toggles' => $toggles,
                                           'logs'    => $logs,
                                           'notices' => $notices,
                                       ]
                                   ]);
        }

        public function SuperAdminDashboard(): \Inertia\Response
        {
            return $this->LoadView([

                                   ]);
        }
    }
