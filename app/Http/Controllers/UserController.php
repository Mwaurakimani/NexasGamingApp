<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use JetBrains\PhpStorm\NoReturn;

class UserController extends Controller
{
    use PasswordValidationRules;
    public function view_current_user_profile(Request $request): \Inertia\Response
    {
        return Inertia::render('Views/Profile');
    }

    public function list(Request $request): \Inertia\Response
    {

        $query = $request->query('search');

        $users = User::where('username', 'like', '%'.$query.'%')
            ->orWhere('email', 'like', '%'.$query.'%')
            ->orWhere('codm_username', 'like', '%'.$query.'%')
            ->orWhere('phone_number', 'like', '%'.$query.'%')
            ->paginate(2);

        $users->appends(['search' => $query]);

        return Inertia::render('Views/Super/Accounts/index',[
            'payload' => $users
        ]);
    }

    public function view_user(Request $request,$id): \Inertia\Response
    {
        $user = User::find($id);

        if($user == null)
            abort('404','User not found');

        return Inertia::render('Views/Super/Accounts/view',[
            'account' => $user
        ]);
    }

    public function update_account(Request $request,$id): \Illuminate\Http\RedirectResponse
    {
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

    #[NoReturn] public function update_password(Request $request, User $user){
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

    public function suspend_account(Request $request,$user)
    {
        $active_user = Auth::user();
        $user = User::findOrFail($user);

        if(str_contains(strtolower($active_user->role_name), 'admin')){
            $user->Active = 0;
            $user->save();
            return [
                'status' => "success",
                'message' => "Account suspended successfully."
            ];
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function unsuspend_account_action(Request $request,$user)
    {
        $active_user = Auth::user();
        $user = User::findOrFail($user);

        if(str_contains(strtolower($active_user->role_name), 'admin')){
            $user->Active = 1;
            $user->save();
            return [
                'status' => "success",
                'message' => "Account activated successfully."
            ];
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function search_user_action(Request $request)
    {

    }
}
