<?php

namespace App\Http\Controllers\ArcadeGamesController\Chess;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChessController extends Controller
{
    public function index(Request $request,$id)
    {
        dd($id);
        return Inertia::render('games/chess/Index',[
        ]);
    }
}
