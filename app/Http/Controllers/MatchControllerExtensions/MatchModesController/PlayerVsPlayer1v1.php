<?php

namespace App\Http\Controllers\MatchControllerExtensions\MatchModesController;

use App\Models\Matches;
use App\Models\Participants;

Class PlayerVsPlayer1v1
{
    public function __construct(Matches $match)
    {
        // Check if the match has 2 participants
        if (Participants::where('match_id', $match->id)->count() >= 2) {
            abort(401, 'This match already has 2 participants.');
        }
    }

    public function validate_match($match): void
    {
        if (Participants::where('match_id', $match->id)->count() >= 2) {
            $match->status = 'Scheduled';
            $match->save();
        }
    }
}