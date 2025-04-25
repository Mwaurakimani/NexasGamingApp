<?php

    namespace App\Http\Controllers\Platform\System;

    use Inertia\Inertia;
    use App\Models\Matches;
    use Illuminate\Http\Request;
    use Illuminate\Support\Carbon;
    use App\Http\Controllers\Controller;

    class ChallengeController extends Controller {
        /**
         * Display a listing of challenges.
         */
        public function index(Request $request)
        {

            $openMatches = Matches::with(['participants.user', 'game', 'matchType'])
                                  ->get()
                                  ->filter(function ($match) {
                                      return $match->participants->count() < $match->matchType->min_players;
                                  })
                                  ->map(function ($match) {
                                      $firstPlayer = $match->participants->first()?->user;

                                      return [
                                          'id'         => $match->id,
                                          'game'       => $match->game->name,
                                          'amount'     => $match->stake,
                                          'player'     => $firstPlayer ? "{$firstPlayer->username}" : 'Unknown',
                                          'avatar'     => $firstPlayer->avatar ?? null,
                                          'rank'       => $firstPlayer->rank ?? 'Unranked',  // Assuming user has a rank field
                                          'created_at' => Carbon::parse($match->created_at)->toDateTimeString(),
                                      ];
                                  });

            return Inertia::render('Challenges/Index', [
                'challenges' => $openMatches,
                'filters'    => $request->only(['amount', 'game', 'rank']),
            ]);
        }

        /**
         * Show the form for creating a new challenge.
         */
        public function create()
        {
            return Inertia::render('Challenges/Create');
        }

        public function viewChess(Request $request, $id): \Inertia\Response
        {
            $match = Matches::with(['participants.user', 'game', 'matchType'])->find($id);

            return Inertia::render('games/chess/ViewChallenge',[
                'match' => $match,
            ]);
        }
    }

