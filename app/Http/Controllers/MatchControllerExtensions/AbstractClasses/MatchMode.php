<?php

namespace App\Http\Controllers\MatchControllerExtensions\AbstractClasses;

use App\Models\Matches;
use App\Models\Participants;

class MatchMode implements \App\Http\Controllers\MatchControllerExtensions\Interfaces\MatchMode
{
    protected int $maxCapacity;
    protected Matches $match;

    public function checkCapacity(): true
    {
        // Check if the match has 100 participants
        if (Participants::where('match_id', $this->match->id)->count() >= $this->maxCapacity) {
            abort(401, 'This match is already at capacity.');
        }

        return true;
    }

    public function validate_match(): void
    {
        //schedule match when full
        if (Participants::where('match_id', $this->match->id)->count() >= $this->maxCapacity) {
            $this->match->status = 'Scheduled';
            $this->match->save();
        }
    }

    public function payPlayers()
    {
        //check if there is enough balance to pay all players
    }

    public function getMaxCapacity(): int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $capacity): void
    {
        $this->maxCapacity = $capacity;
    }

    public function getMatch(): Matches
    {
        return $this->match;
    }

    public function setMatch(Matches $match): void
    {
        $this->match = $match;
    }
}
