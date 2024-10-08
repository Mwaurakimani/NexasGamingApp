<?php

namespace App\Actions\Fortify;

use App\Models\role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'codm_username' => ['required', 'string', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();


        return User::create([
            'username' => $input['username'],
            'email' => $input['email'],
            'codm_username' => $input['codm_username'],
            'phone_number' => $input['phone_number'],
            'role_id' => role::where('name','Guest')->first()->id,
            'password' => Hash::make($input['password']),
        ]);
    }
}
