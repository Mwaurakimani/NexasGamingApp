<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Wallet;
use App\Models\Deposits;
use App\Models\Withdrawals;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

                $deposits = Deposits::orderBy('created_at', 'desc')->paginate(15, ['*'], 'deposits_page');

                $deposits->getCollection()->transform(function ($transaction) {
                    $transaction->processed_by = User::find($transaction->processed_by)?->username;
                    $transaction->account = User::find($transaction->user_id)?->username;
                    return $transaction;
                });

                $withdrawals = Withdrawals::orderBy('created_at', 'desc')->paginate(15, ['*'], 'withdrawals_page');

                $withdrawals->getCollection()->transform(function ($transaction) {

                    $transaction->processed_by = User::find($transaction->processed_by)?->username;
                    $transaction->account = User::find($transaction->user_id)?->username;

                    return $transaction;
                });


                $wallet_transactions->getCollection()->transform(function ($transaction) {
                    $actor_username = User::find($transaction->actor_id)->username;
                    $account_username = User::find($transaction->transfer_to)->username;

                    $transaction->actor_username = $actor_username;
                    $transaction->account = $account_username;

                    return $transaction;
                });

                return Inertia::render($view, [
                    'balance'      => $user->balance,
                    'transactions' => $wallet_transactions,
                    'deposits'     => $deposits,
                    'withdrawals'  => $withdrawals
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
                $transactions = Transactions::orderBy('created_at', 'desc')->where('receiver_id', Auth::user()->id)->paginate(15, ['*'], 'transactions_page');

                $transactions->getCollection()->transform(function ($transaction) {
                    $actor_username = User::find($transaction->sender_id)->username;
                    $account_username = User::find($transaction->receiver_id)->username;

                    $transaction->actor_username = $actor_username;
                    $transaction->account = $account_username;

                    return $transaction;
                });


                $view = 'Views/Players/Transactions/Transactions';

                return Inertia::render($view, [
                    'balance'      => $user->balance,
                    'transactions' => $transactions,
                ]);
                break;
            default:
                return redirect()->route('dashboard');
        }

        return Inertia::render($view, [
            'balance'      => $user->balance,
            'transactions' => $transactions
        ]);
    }

    public function list_deposits()
    {
        $deposits = Deposits::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->paginate(15, ['*'], 'deposits_page');

        $deposits->getCollection()->transform(function ($transaction) {
            $processed_by = User::find($transaction->processed_by)?->username;
            $transaction->processed_by = $processed_by;

            return $transaction;
        });

        $view = 'Views/Players/Transactions/Deposits';

        return Inertia::render($view, [
            'balance'  => Auth::user()->balance,
            'deposits' => $deposits,
        ]);
    }

    public function list_withdrawals()
    {
        $withdrawals = Withdrawals::orderBy('created_at', 'desc')->where('user_id', Auth::user()->id)->paginate(15, ['*'], 'withdrawals_page');

        $withdrawals->getCollection()->transform(function ($transaction) {

            $processed_by = User::find($transaction->processed_by)?->username;
            $transaction->processed_by = $processed_by;

            return $transaction;
        });

        $view = 'Views/Players/Transactions/Withdrawals';

        return Inertia::render($view, [
            'balance'     => Auth::user()->balance,
            'withdrawals' => $withdrawals
        ]);
    }

    public function deposit(Request $request)
    {
        $request->validate([
                               'tokens'           => 'required|integer|min:1', // Ensure it's a positive integer
                               'phone_number'     => 'required|string|regex:/^0[7][0-9]{8}$/', // Validate Kenyan phone numbers (starting with 07 and 10 digits long)
                               'transaction_code' => 'required|string|max:255|unique:deposits,transaction_code', // Ensure it's a string and not too long
                           ]);

        Deposits::create([
                             'user_id'          => Auth::user()->id,
                             'amount'           => $request->input('tokens'),
                             'phone_number'     => $request->input('phone_number'),
                             'transaction_code' => $request->input('transaction_code'),
                         ]);

        return redirect()->back()->with('success_message', "Deposit Request Made Successfully...");
    }

    /**
     * @throws ValidationException
     */
    public function withdraw(Request $request)
    {
        $validatedData = $request->validate([
                                                'amount'       => 'required|integer|min:1', // Ensure it's a positive integer
                                                'phone_number' => 'required|string|regex:/^0[7][0-9]{8}$/', // Validate Kenyan phone numbers
                                                'password'     => 'required|string|min:8', // Adjust min length as needed
                                            ]);

        // Check if the user's balance is sufficient
        $user = Auth::user();
        if ($user->balance < $validatedData['amount']) {
            throw ValidationException::withMessages([
                                                        'amount' => 'Insufficient balance.',
                                                    ]);
        }

        // Check if the provided password matches the user's password
        if (!Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                                                        'password' => 'Invalid password.',
                                                    ]);
        }

        // Check if the provided password matches the user's password
        if (Withdrawals::where('user_id', $user->id)->where('status', 'pending')->first() != null) {
            throw ValidationException::withMessages([
                                                        'amount' => 'You have pending requests',
                                                    ]);
        }

        // Create a withdrawal record
        Withdrawals::create([
                                'user_id'      => $user->id,
                                'amount'       => $validatedData['amount'],
                                'phone_number' => $validatedData['phone_number'],
                            ]);

        return redirect()->back()->with('success_message', 'Withdrawal Request Made successful.',);
    }


    public function confirmWithdrawal(Request $request)
    {
        $validatedData = $request->validate([
                                                'transaction_code' => 'required|string|max:255|unique:withdrawals,transaction_code', // Ensure it's unique in withdrawals
                                                'password'         => 'required|string|min:8', // Adjust min length as needed
                                                'withdrawal_id'    => [
                                                    'required',
                                                    'exists:withdrawals,id', // Ensure withdrawal_id exists in the withdrawals table
                                                    function ($attribute, $value, $fail) {
                                                        // Check if the status is pending
                                                        $withdrawal = Withdrawals::find($value);
                                                        if ($withdrawal && $withdrawal->player_status !== 'pending') {
                                                            $fail('The selected withdrawal is not pending.');
                                                        }
                                                    },
                                                ],
                                            ]);


        // Check if the user's balance is sufficient
        $user = Auth::user();

        // Check if the provided password matches the user's password
        if (!Hash::check($validatedData['password'], $user->password)) {
            throw ValidationException::withMessages([
                                                        'password' => 'Invalid password.',
                                                    ]);
        }

        $withdrawal = Withdrawals::find($request->withdrawal_id);

        if ($withdrawal->moderator_status == 'pending') {
            throw ValidationException::withMessages([
                                                        'transaction_code' => 'Moderator has not confirmed Transaction',
                                                    ]);
        }

        $withdrawal->transaction_code = $validatedData['transaction_code'];
        $withdrawal->player_status = "confirmed";
        $withdrawal->status = "processed";
        $withdrawal->save();

        return redirect()->back()->with('success_message', 'Withdrawal was successful.',);
    }
}
