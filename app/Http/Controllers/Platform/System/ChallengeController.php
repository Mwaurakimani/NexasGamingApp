<?php

    namespace App\Http\Controllers\Platform\System;

    use Inertia\Inertia;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

    class ChallengeController extends Controller
    {
        /**
         * Display a listing of challenges.
         */
        public function index(Request $request)
        {
            // For now, just return dummy data to populate the UI
            $dummyChallenges = collect([
                                           [
                                               'id' => 1,
                                               'game' => 'Chess',
                                               'amount' => 100,
                                               'player' => 'Kimani M.',
                                               'avatar' => null,
                                               'rank' => 'Gold',
                                               'created_at' => now()->subMinutes(10)->toDateTimeString(),
                                           ],
                                           [
                                               'id' => 2,
                                               'game' => 'Chess',
                                               'amount' => 250,
                                               'player' => 'Wanjiru N.',
                                               'avatar' => null,
                                               'rank' => 'Silver',
                                               'created_at' => now()->subMinutes(45)->toDateTimeString(),
                                           ],
                                       ]);

            return Inertia::render('Challenges/Index', [
                'challenges' => $dummyChallenges,
                'filters' => $request->only(['amount', 'game', 'rank']),
            ]);
        }

        /**
         * Show the form for creating a new challenge.
         */
        public function create()
        {
            return Inertia::render('Challenges/Create');
        }

        // Future methods like store(), show(), accept(), etc. can be added here
    }
