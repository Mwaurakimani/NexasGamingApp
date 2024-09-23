<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function list_transactions()
    {
        $user = Auth::user();
        $role = Auth::user()->role->name;
        $transactions = null;
        $view = 'Views/Transactions';


        switch ($role) {
            case 'Super Admin':
                $view = 'Views/Super/Transactions/Transactions';

                $wallet_transactions = Wallet::orderBy('created_at', 'desc')->paginate(5, ['*'], 'wallet_page');


                $wallet_transactions->getCollection()->transform(function ($transaction) {
                    $actor_username = User::find($transaction->actor_id)->username;
                    $account_username = User::find($transaction->transfer_to)->username;

                    $transaction->actor_username = $actor_username;
                    $transaction->account = $account_username;

                    return $transaction;
                });

                return Inertia::render($view, [
                    'balance' => $user->balance,
                    'transactions' => $wallet_transactions
                ]);
            case 'Admin':
                $transactions = [];
                $view = 'Views/Admin/Transactions';
                break;
            case 'Moderator':
                $transactions = [];
                $view = 'Views/Moderators/Transactions';
                break;
            case 'Player':
            case 'Guest':
                $transactions = Transactions::where('receiver_id', Auth::user()->id)->paginate(10);
                $view = 'Views/Players/Transactions';

                $transactions->getCollection()->transform(function ($transaction) {
                    $actor_username = User::find($transaction->sender_id)->username;
                    $account_username = User::find($transaction->receiver_id)->username;

                    $transaction->actor_username = $actor_username;
                    $transaction->account = $account_username;

                    return $transaction;
                });

                return Inertia::render($view, [
                    'balance' => $user->balance,
                    'transactions' => $transactions
                ]);
                break;
            default:
                return redirect()->route('dashboard');
        }

        return Inertia::render($view, [
            'balance' => $user->balance,
            'transactions' => $transactions
        ]);
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'tokens' => 'required|integer|min:1', // Ensure it's a positive integer
            'phone_number' => 'required|string|regex:/^0[7][0-9]{8}$/', // Validate Kenyan phone numbers (starting with 07 and 10 digits long)
            'transaction_code' => 'required|string|max:255', // Ensure it's a string and not too long
        ]);

    }
}
