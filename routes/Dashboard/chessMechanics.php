<?php

    use App\Events\ChessMoveMade;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;

    Route::post('/moveChessPiece/{matchID}', function (Request $request, $matchID) {

        $move = collect(json_decode($request->input('action')));

        event(new ChessMoveMade($move->toArray(), $matchID));

        return response()->json($request->toArray());
    })->name('moveChessPiece');







