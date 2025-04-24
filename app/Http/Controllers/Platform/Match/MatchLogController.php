<?php

namespace App\Http\Controllers\Platform\Match;

use App\Models\MatchLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchLogController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
                                       'match_id' => 'required|exists:matches,id',
                                       'user_id' => 'nullable|exists:users,id',
                                       'type' => 'required|in:move,join,leave,checkmate,message,disconnect',
                                       'content' => 'required|string|max:1000',
                                   ]);

        $log = MatchLog::create($data);

        return response()->json([
                                    'message' => 'Log recorded.',
                                    'log' => $log
                                ]);
    }
}

