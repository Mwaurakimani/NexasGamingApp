<?php

namespace App\Http\Controllers\MatchControllerExtensions\MatchModesController;

use App\Models\Matches;
use App\Http\Controllers\MatchControllerExtensions\AbstractClasses\MatchMode;

Class PlayerVsPlayer1v1 extends MatchMode
{
    public function __construct(Matches $match)
    {
        abort(404,'Mode Not available');
    }
}