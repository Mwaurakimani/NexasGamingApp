<?php

namespace App\Http\Controllers\MatchControllerExtensions\MatchModesController;

use App\Models\Matches;
use App\Models\Participants;

Class PlayerVsPlayer1v1
{
    public function __construct(Matches $match)
    {
        // Check if the match has 2 participants
        $participantCount = Participants::where('match_id', $match->id)->count();

        if ($participantCount >= 2) {
            abort(401, 'This match already has 2 participants.');
        }
    }

    public function validate_match($match): void
    {
        $players = Participants::where('match_id', $match->id)->count();

        if ($players >= 2) {
            $match->status = 'Scheduled';
            $match->save();
        }
    }
}