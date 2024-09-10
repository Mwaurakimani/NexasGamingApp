<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function ListMatches(Request $request): \Inertia\Response
    {
        return Inertia::render('Views/Matches');
    }

    public function OpenMatches(): \Inertia\Response
    {
        return Inertia::render('Views/Players/MatchView');
    }
}
