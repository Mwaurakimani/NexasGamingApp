<?php

namespace App\Http\Controllers\ArcadeGamesController\Chess;

use Inertia\Inertia;
use App\Models\Matches;
use App\Models\MatchLog;
use App\Models\MatchParticipant;
use App\Events\UserNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChessController extends Controller
{
    public function index(Request $request, $id)
    {
        // 1. Fetch the match (or fail if not found)
        $match = Matches::findOrFail($id);

        // 2. Add this user to participants (if not already there)
        MatchParticipant::firstOrCreate(
            [
                'match_id' => $match->id,
                'user_id'  => $request->user()->id,
            ],
            [
                'role'            => 'player',
                'is_ready'        => true,
                'timer_remaining' => $match->timer * 60,
            ]
        );

        // 3. If it's still pending, flip status → active
        if ($match->status === 'pending') {
            $match->status = 'active';
            $match->save();
        }

        // 4. Create a "join" log entry
        $log = MatchLog::create([
                                    'match_id' => $match->id,
                                    'user_id'  => $request->user()->id,
                                    'type'     => 'join',
                                    'content'  => $request->user()->name . ' joined the match',
                                ]);

        // 5. Broadcast it so the other player sees you joined
        $otherUserIds = MatchParticipant::where('match_id', $match->id)
                                        ->where('user_id', '<>', $request->user()->id)
                                        ->pluck('user_id');

        foreach ($otherUserIds as $userId) {
            broadcast(new UserNotification(
                          $userId,
                          'Your challenge has been accepted.',
                          ['match_id' => $match->id]
                      ));
        }

        // 6. Finally render the board, passing in participants & logs
        return Inertia::render('games/chess/Index',[
            'match' => $match,
            'logs' => $log,
        ]);
    }
}
