<?php

namespace App\Http\Controllers\MatchControllerExtensions\MatchModesController;

use App\Models\User;
use App\Models\Matches;
use App\Models\Transactions;
use App\Http\Controllers\MatchControllerExtensions\AbstractClasses\MatchMode;

class BattleRoyalSolos extends MatchMode
{
    public function __construct(Matches $match, $checkCapacity = false)
    {
        $this->setMatch($match);
        $this->setMaxCapacity(100);

        if ($checkCapacity)
            $this->checkCapacity();

    }

    /**
     * @throws \Exception
     */
    public function payPlayers(): void
    {
        $match = $this->getMatch();
        $players = $match->players;

        foreach ($players as $player) {
            $matchData = $player->matches()->where('match_id', $match->id)->first();
            //TODO: match the user and moderator score



            $score = $matchData->pivot->user_score != $matchData->pivot->moderator_score
                ? $matchData->pivot->results ==  null ? $matchData->pivot->user_score : $matchData->pivot->moderator_score
                : $matchData->pivot->moderator_score;
            $stake = $match->stake;
            $grossPayout = $score * $stake;
            $netPayout = $grossPayout * 0.9;

            $moderator = User::where('username', 'Super Admin')->first();

            $player->balance += $netPayout;

            $moderator->balance -= $netPayout;

            $transaction = new Transactions();
            $transaction->sender_id = $moderator->id;
            $transaction->receiver_id = $player->id;
            $transaction->amount = $netPayout;
            $transaction->transaction_type = 'Payout';
            $transaction->description = 'Payout for Match id' . $match->id;
            $transaction->ref = null;
            $transaction->status = 'completed';

            $player->save();
            $moderator->save();
            $transaction->save();
        }
    }

}