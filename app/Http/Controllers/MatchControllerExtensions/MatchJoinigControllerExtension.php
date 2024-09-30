<?php

namespace App\Http\Controllers\MatchControllerExtensions;

use App\Models\User;
use Mockery\Exception;
use App\Models\Matches;
use App\Models\Participants;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MatchControllerExtensions\MatchModesController\PlayerVsPlayer1v1;

trait MatchJoinigControllerExtension
{
    public function one_vs_one_join_match($request, $matchId)
    {
        $userId = auth()->id();
        $matchDetails = Matches::find($matchId);

        if (!$matchDetails)
            return response()->json(['message' => 'Match not found.'], 404);

        $global_rule_passed = new GlobalMatchRules($matchDetails);
        $mode_1v1_rules_pass = new PlayerVsPlayer1v1($matchDetails);

        DB::beginTransaction();

        try {
            $mod = User::where('username', 'Super Admin')->first();
            // Create a new match participant entry
            $participant = Participants::create([
                                                    'match_id'        => $matchId,
                                                    'user_id'         => $userId,             // Use the authenticated user's ID
                                                ]);
            $transfer = Transactions::create([
                                                 'sender_id'        => auth()->id(),
                                                 'receiver_id'      => $mod->id,
                                                 'amount'           => $matchDetails->stake,
                                                 'transaction_type' => 'Stake',
                                                 'description'      => 'Stake for Match id'.$matchDetails->id,
                                                 'ref'              => null,
                                                 'status'           => 'completed',
                                             ]);

            $sender_balance = auth()->user()->balance - $matchDetails->stake;
            $receiver_balance = $mod->balance + $matchDetails->stake;

            auth()->user()->update(['balance' => $sender_balance]);
            $mod->update(['balance' => $receiver_balance]);

            $mode_1v1_rules_pass->validate_match($matchDetails);

            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
        }

        return response()->json(['message' => 'Successfully joined the match.'], 200);
    }

    public function two_vs_two_join_match($request, $match)
    {
        // Implement match joining logic
    }

    public function five_vs_five_join_match($request, $match)
    {
        // Implement match joining logic
    }

    public function brs_join_match($request, $match)
    {
        // Implement match joining logic
    }

    public function brd_join_match($request, $match)
    {
        // Implement match joining logic
    }

    public function brq_join_match($request, $match)
    {
        // Implement match joining logic
    }

}

