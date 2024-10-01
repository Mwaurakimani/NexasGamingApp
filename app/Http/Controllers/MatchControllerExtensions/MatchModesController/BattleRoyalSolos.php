<?php

namespace App\Http\Controllers\MatchControllerExtensions\MatchModesController;

use App\Models\Matches;
use App\Models\Participants;

class BattleRoyalSolos
{
    public function __construct(Matches $match)
    {
        // Check if the match has 100 participants
        if (Participants::where('match_id', $match->id)->count() >= 100) {
            abort(401, 'This match is already at capacity.');
        }
    }

    public function validate_match($match): void
    {
        if (Participants::where('match_id', $match->id)->count() >= 100) {
            $match->status = 'Scheduled';
            $match->save();
        }
    }

}