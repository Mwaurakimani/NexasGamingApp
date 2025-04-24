<?php

namespace App\Http\Controllers\Platform\Match;

use App\Models\MatchParticipant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchParticipantController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
                                       'match_id' => 'required|exists:matches,id',
                                       'user_id' => 'required|exists:users,id',
                                       'role' => 'required|in:player,spectator',
                                   ]);

        $exists = MatchParticipant::where('match_id', $data['match_id'])
                                  ->where('user_id', $data['user_id'])
                                  ->exists();

        if ($exists) {
            return response()->json(['message' => 'User already joined this match.'], 409);
        }

        return MatchParticipant::create($data);
    }

    public function update(Request $request, MatchParticipant $matchParticipant)
    {
        $validated = $request->validate([
                                            'is_ready' => 'nullable|boolean',
                                            'score' => 'nullable|array',
                                            'timer_remaining' => 'nullable|integer|min:0',
                                        ]);

        $matchParticipant->update($validated);

        return response()->json(['message' => 'Participant updated.', 'participant' => $matchParticipant]);
    }
}

