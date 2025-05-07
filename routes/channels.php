<?php

    use App\Models\MatchParticipant;
    use Illuminate\Support\Facades\Broadcast;


    Broadcast::channel('user.{userId}', function ($user, $userId) {
        // only allow the real user with that ID to join
        return (int) $user->id === (int) $userId;
    });


    Broadcast::channel('chess.match.{matchId}', function ($user, $matchId) {
//        $return = MatchParticipant::where('match_id', $matchId)
//                                  ->where('user_id', $user->id)
//                                  ->exists();

        return true;
    });


    Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
        return (int)$user->id === (int)$id;
    });

    Broadcast::channel('presence-users', function ($user) {
        return [
            'id'     => $user->id,
            'name'   => $user->username,
        ];
    });

    Broadcast::channel('match.{matchId}', function ($user, $matchId) {
        // Only allow users who are participants in this match
        return MatchParticipant::where('match_id', $matchId)
                                           ->where('user_id', $user->id)
                                           ->exists();
    });



