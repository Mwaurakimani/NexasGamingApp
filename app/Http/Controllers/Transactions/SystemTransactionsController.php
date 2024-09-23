<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
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

        //validate password of throw error in the pasword field
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


    function encrypt($plaintext, $key) {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($plaintext, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $ciphertext);
    }
    function decrypt($ciphertext, $key) {
        $cipher = "aes-256-cbc";
        $ciphertext = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($ciphertext, 0, $ivlen);     $ciphertext = substr($ciphertext, $ivlen);
        return openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA,
            $iv);
    }

}
