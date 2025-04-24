<?php

namespace App\Http\Controllers\Platform\System;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Wallet;
use App\Models\Deposits;
use App\Models\Withdrawals;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SystemTransactionsController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function generateTokens(Request $request)
    {
        $user = $this->validateAccountDetails($request);

        $wallet_action = Wallet::create([
                                            "actor_id"    => Auth::user()->id,
                                            "transfer_to" => $request->input('receiver_id'),
                                            "tokens"      => $request->input('tokens'),
                                            "action"      => "generated",
                                        ]);

        $balance = $user->balance + $request->input('tokens');
        $user->update(['balance' => $balance]);

        return redirect()->back()->with('success_message', 'Generated successfully');

    }

    public function seizeTokens(Request $request)
    {
        $validatedData = $request->validate([
                                                'seized_username' => 'required|string|exists:users,username|max:255', // Check if username exists in users table
                                                'seized_id'       => 'required|exists:users,id', // Check if user ID exists in users table
                                                'password'        => 'required|string|min:8', // Adjust min length as needed
                                                'tokens'          => 'required|integer|min:1', // Ensure it's a non-negative integer
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
                                                        'seized_id'       => ['Account Details are incorrect'],
                                                    ]);


        if ($user->balance < $request->input('tokens'))
            abort(403, 'Not enough balance to perform action');

        $wallet_action = Wallet::create([
                                            "actor_id"    => Auth::user()->id,
                                            "transfer_to" => $request->input('seized_id'),
                                            "tokens"      => $request->input('tokens'),
                                            "action"      => "burned",
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
                                             'sender_id'        => $from->id,
                                             'receiver_id'      => $to->id,
                                             'amount'           => $request->input('tokens'),
                                             'transaction_type' => 'transfer',
                                             'description'      => "direct transfer",
                                             'ref'              => null,
                                             'status'           => 'completed',
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
                                                'receiver_id'       => 'required|exists:users,id', // Check if user ID exists in users table
                                                'password'          => 'required|string|min:8', // Adjust min length as needed
                                                'tokens'            => 'required|integer|min:1', // Ensure it's a non-negative integer
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
                                                        'receiver_id'       => ['Account Details are incorrect'],
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
                                            'id'      => [
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
                                            'amount'  => 'required|numeric|min:1', // Ensure amount is above 0
                                            'status'  => 'required|in:processed,confirmed,rejected', // Status must be one of these values
                                            'notes'   => 'required|string', // Notes must be included
                                            'type'    => 'required|in:deposit,withdrawal', // Type must be either deposit or withdrawal
                                        ]);

        // Find the transaction based on type
        $transaction = $validated['type'] === 'deposit'
            ? Deposits::find($validated['id'])
            : Withdrawals::find($validated['id']);

        // If no transaction is found, return 404
        if (!$transaction) {
            abort(404, 'Transaction not found');
        }

        $user = User::find($transaction->user_id);

        if ($request->input('status') != 'rejected')
            $this->updateUsersBalance($transaction->user_id, $request->input('amount'), $request->input('type'));

        if ($validated['type'] === 'deposit') {
            $transaction->status = $request->input('status');
        } else {
            $transaction->moderator_status = $request->input('status');
        }

        $transaction->notes = $request->input('notes');
        $transaction->processed_by = Auth::user()->id;
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
