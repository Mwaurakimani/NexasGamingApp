<?php

namespace App\Http\Controllers\MatchControllerExtensions\MatchModesController;

use App\Http\Controllers\MatchControllerExtensions\AbstractClasses\MatchMode;

Class BattleRoyalDuos extends MatchMode
{
    public function __construct()
    {
        abort(404,'Mode Not available');
    }
}