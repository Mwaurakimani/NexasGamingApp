<?php

namespace App\Http\Controllers\MatchControllerExtensions;

use App\Models\Matches;
use App\Models\Participants;
use Illuminate\Support\Facades\Auth;

Class GlobalMatchRules
{
    public function __construct(Matches $match)
    {
        //match should be active for joining
        if ($match->status === 'Inactive' || $match->status === 'pending')
            abort(401, 'Match is not active for joining.');

        //user should not be already participating in the match
        if (Participants::where('match_id', $match->id)->where('user_id', auth()->id())->first())
            abort(401, 'You are already participating in this match.');

        if (Auth::user()->balance < $match->stake)
            abort(401, 'Insufficient balance. Please make a deposit and try again.');

    }
}
