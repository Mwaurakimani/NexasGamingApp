<?php

namespace App\Http\Controllers\MatchControllerExtensions;

use App\Models\Matches;

trait MatchesControllerExtension
{
    public function admin_list_matches($request): array
    {
        $match = Matches::paginate(10);
        $currentMatch = Matches::where('status', 'Pending')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->first()
        ;

        return [
            'matches'       => $match,
            'current_match' => $currentMatch
        ];
    }

    public function player_list_matches($request): array
    {
        $match = Matches::where('status','Active')->simplePaginate(10);
        
        return [
            'matches'       => $match,
        ];
    }

}