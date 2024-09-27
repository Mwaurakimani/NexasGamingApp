<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Deposits;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SystemTransactionsController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function generateTokens(Request $request)
    {
        $user = $this->validateAccountDetails($request);

        $wallet_action = Wallet::create([
            "actor_id" => Auth::user()->id,
            "transfer_to" => $request->input('receiver_id'),
            "tokens" => $request->input('tokens'),
            "action" => "generated",
        ]);

        $balance = $user->balance + $request->input('tokens');
        $user->update(['balance' => $balance]);

        return redirect()->back()->with('success_message', 'Generated successfully');

    }

    public function seizeTokens(Request $request)
    {
        $validatedData = $request->validate([
            'seized_username' => 'required|string|exists:users,username|max:255', // Check if username exists in users table
            'seized_id' => 'required|exists:users,id', // Check if user ID exists in users table
            'password' => 'required|string|min:8', // Adjust min length as needed
            'tokens' => 'required|integer|min:1', // Ensure it's a non-negative integer
        ]);

        //validate password of throw error in the pasword field
        if (!Hash::check($request->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
        }

        $user = User::find($request->input('seized_id'));


        if ($user->username != $request->input('seized_username'))
            throw ValidationException::withMessages([
                'seized_username' => ['Account Details are incorrect'],
                'seized_id' => ['Account Details are incorrect'],
            ]);


        if ($user->balance < $request->input('tokens'))
            abort(403, 'Not enough balance to perform action');

        $wallet_action = Wallet::create([
            "actor_id" => Auth::user()->id,
            "transfer_to" => $request->input('seized_id'),
            "tokens" => $request->input('tokens'),
            "action" => "burned",
        ]);

        $balance = $user->balance - $request->input('tokens');
        $user->update(['balance' => $balance]);

        return redirect()->back()->with('success_message', 'Seized successfully');

    }

    /**
     * @throws ValidationException
     */
    public function transferTokens(Request $request)
    {
        $user = $this->validateAccountDetails($request);

        $from = Auth::user();

        $to = User::find($request->input('receiver_id'));


        $transfer = Transactions::create([
            'sender_id' => $from->id,
            'receiver_id' => $to->id,
            'amount' => $request->input('tokens'),
            'transaction_type' => 'transfer',
            'description' => "direct transfer",
            'ref' => null,
            'status' => 'completed',
        ]);

        $sender_balance = $from->balance - $request->input('tokens');
        $receiver_balance = $to->balance + $request->input('tokens');

        $from->update(['balance' => $sender_balance]);
        $to->update(['balance' => $receiver_balance]);

        return redirect()->back()->with('success_message', 'Transferred successfully');
    }

    /**
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function validateAccountDetails(Request $request)
    {
        $validatedData = $request->validate([
            'receiver_username' => 'required|string|exists:users,username|max:255', // Check if username exists in users table
            'receiver_id' => 'required|exists:users,id', // Check if user ID exists in users table
            'password' => 'required|string|min:8', // Adjust min length as needed
            'tokens' => 'required|integer|min:1', // Ensure it's a non-negative integer
        ]);

        //validate password or throw error in the password field
        if (!Hash::check($request->password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
        }

        $user = User::find($request->input('receiver_id'));

        if ($user->username != $request->input('receiver_username'))
            throw ValidationException::withMessages([
                'receiver_username' => ['Account Details are incorrect'],
                'receiver_id' => ['Account Details are incorrect'],
            ]);

        return $user;
    }

    public function pendingDeposit()
    {
        $deposits = Deposits::where('status', 'pending')->paginate(10, ['*'], 'deposits_page');

        $deposits->getCollection()->transform(function ($transaction) {
            $transaction->processed_by = User::find($transaction->processed_by)?->username;
            $transaction->account = User::find($transaction->user_id)?->username;
            return $transaction;
        });

        return Inertia::render('Views/Super/Transactions/PendingDeposits', [
            "deposits" => $deposits
        ]);
    }

    public function pendingWithdrawal()
    {
        $withdrawals = Withdrawals::where('status', 'pending')->paginate(10, ['*'], 'withdrawal_page');

        $withdrawals->getCollection()->transform(function ($transaction) {
            $transaction->processed_by = User::find($transaction->processed_by)?->username;
            $transaction->account = User::find($transaction->user_id)?->username;
            return $transaction;
        });

        return Inertia::render('Views/Super/Transactions/PendingWithdraw', [
            "withdrawals" => $withdrawals
        ]);
    }


    public function updateTransaction(Request $request)
    {
        // Validate the request input
        $validated = $request->validate([
            'id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('type') === 'deposit' && !Deposits::where('id', $value)->exists()) {
                        $fail('The selected deposit id is invalid.');
                    } elseif ($request->input('type') === 'withdrawal' && !Withdrawals::where('id', $value)->exists()) {
                        $fail('The selected withdrawal id is invalid.');
                    }
                }
            ],
            'user_id' => 'required|exists:users,id', // Ensure user_id exists in users table
            'amount' => 'required|numeric|min:1', // Ensure amount is above 0
            'transaction_code' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if (!Deposits::where('transaction_code', $value)->exists() && !Withdrawals::where('transaction_code', $value)->exists()) {
                        $fail('The selected transaction code is invalid.');
                    }
                }
            ],
            'status' => 'required|in:processed,rejected', // Status must be one of these values
            'notes' => 'required|string', // Notes must be included
            'type' => 'required|in:deposit,withdrawal', // Type must be either deposit or withdrawal
        ]);

        // Find the transaction based on type
        $transaction = $validated['type'] === 'deposit'
            ? Deposits::find($validated['id'])
            : Withdrawals::find($validated['id']);

        // If no transaction is found, return 404
        if (!$transaction) {
            abort(404, 'Transaction not found');
        }

        $transaction = null;
        if ($request->input('type') == 'deposit') {
            $transaction = Deposits::find($request->input('id'));
        } else if ($request->input('type') == 'withdrawal') {
            $transaction = Withdrawals::find($request->input('id'));
        } else {
            abort(401, "Invalid Entry");
        }

        $user = User::find($transaction->user_id);

        if ($request->input('status') != 'rejected')
            $this->updateUsersBalance($transaction->user_id, $request->input('amount'), $request->input('type'));


        $transaction->status = $request->input('status');
        $transaction->processed_by = Auth::user()->id;
        $transaction->notes = $request->input('notes');
        $transaction->save();


        return redirect()->route('transactions.list');
    }

    private function updateUsersBalance($user_id, $amount, $type)
    {
        $user = User::find($user_id);

        if ($type == 'deposit') {
            $user->balance = $user->balance + $amount;
        } else if ($type == 'withdrawal') {
            if ($user->balance < $amount) {
                abort(403, 'Insufficient balance to perform withdrawal');
            }

            $user->balance = $user->balance - $amount;
        }
        $user->save();
    }

}
