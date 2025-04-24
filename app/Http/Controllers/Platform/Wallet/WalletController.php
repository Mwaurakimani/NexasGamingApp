<?php

namespace App\Http\Controllers\Platform\Wallet;



use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function index()
    {
        $wallet = Wallet::firstOrCreate([
                                            'user_id' => Auth::id()
                                        ]);

        return response()->json([
                                    'balance' => $wallet->balance,
                                    'wallet' => $wallet
                                ]);
    }
}

