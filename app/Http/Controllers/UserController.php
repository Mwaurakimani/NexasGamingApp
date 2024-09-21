<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    use PasswordValidationRules;
    public function view_current_user_profile(Request $request)
    {
        return Inertia::render('Views/Profile');
    }

    public function list()
    {
        $accounts = User::all();
        return Inertia::render('Views/Super/Accounts/index',[
            'accounts' => $accounts
        ]);
    }

    public function view_user(Request $request,$id){
        $user = User::find($id);

        if($user == null)
            abort('404','User not found');

        return Inertia::render('Views/Super/Accounts/view',[
            'account' => $user
        ]);
    }

    public function update_account(Request $request,$id){
        $user = User::find($id);
        $role = role::where('name', Auth::user()->role_name)->first();

        if($user == null)
            abort('404','User not found');
        else if ($role->name != 'Super Admin' && $user->email != Auth::user()->email)
            abort('403','You can only update your account');

        Validator::make($request->input(), [
            'username' => ['required', 'string', 'max:255',Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'codm_username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_name' => ['required', 'string', 'max:255', Rule::in(['Super Admin', 'Admin', 'Moderator', 'Player', 'Guest'])]
        ])->validated();

        $user->update([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'codm_username' => $request->input('codm_username'),
            'phone_number' => $request->input('phone_number'),
            'role_id' => role::where('name',$request->input('role_name'))->first()->id,
        ]);

        return redirect()->route('accounts.view_user',$user->id)->with('success_message','User Updated successfully');;
    }

    public function update_password(Request $request, User $user){
        Validator::make($request->input(), [
            'current_password' => ['required', 'string', 'current_password:web'],
            'password' => $this->passwordRules(),
            'password_confirmation' => ['required', 'string','same:password'],
        ], [
            'current_password' => __('The provided password does not match your current password.'),
        ])->validate();

        dd("validated");

        $user->forceFill([
            'password' => bcrypt($request->input('password')),
        ])->save();
    }
}
