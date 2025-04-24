<?php

    namespace App\Http\Controllers;

    use App\Models\role;
    use App\Models\User;
    use Inertia\Inertia;
    use Illuminate\Http\Request;
    use Illuminate\Validation\Rule;
    use JetBrains\PhpStorm\NoReturn;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Validator;
    use App\Actions\Fortify\PasswordValidationRules;

    class UserController extends Controller {
        use PasswordValidationRules;

        public function index(Request $request)
        {
            $users = User::query()
                         ->when($request->search, fn($q) => $q->where('username', 'like', "%{$request->search}%"))
                         ->when($request->role, fn($q) => $q->where('role', $request->role))
                         ->orderByDesc('id')
                         ->paginate(15)
                         ->withQueryString();

            return Inertia::render('Admin/Users', [
                'users'   => $users,
                'filters' => $request->only(['search', 'role']),
                'stats'   => [
                    'total'    => User::count(),
                    'active'   => User::where('is_active', true)->count(),
                    'inactive' => User::where('is_active', false)->count(),
                    'admins'   => User::where('role', 'Admin')->count(),
                ]
            ]);
        }

        public function show(User $user)
        {
            return Inertia::render('Admin/Users/View', [
                'user' => $user,
                'stats' => [
                    'games_played' => 42,
                    'win_rate' => 60,
                    'rating' => 4.3,
                ],
//                'transactions' => Transactions::where('user_id', $user->id)->latest()->take(10)->get(),
//                'matches' => [
//                    'played' => Matches::where('user_id', $user->id)->where('status', 'played')->take(5)->get(),
//                    'upcoming' => Matches::where('user_id', $user->id)->where('status', 'upcoming')->take(5)->get(),
//                ],
            ]);
        }

        public function edit(User $user)
        {
            return Inertia::render('Admin/Users/Edit', [
                'user' => $user,
            ]);
        }

        public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
        {
            $validated = $request->validate([
                                                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                                                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                                                'phone_number' => 'required|string|max:15|unique:users,phone_number,' . $user->id,
                                                'role' => 'required|string|in:Guest,Player,Moderator,Manager,Admin,Super Admin',
                                                'Active' => 'required|in:0,1,2'
                                            ]);
            $user->update($validated);

            return redirect()
                ->route('admin.users')
                ->with('success', 'User updated successfully.');
        }


        public function view_current_user_profile(Request $request): \Inertia\Response
        {
            $user = Auth::user();
            return Inertia::render('Views/Profile', [
                'user' => $user
            ]);
        }

        public function update_current_user_profile(Request $request)
        {
            $this->update_account($request, Auth::user()->id);
        }

        public function update_current_user_password(Request $request)
        {
            // Validate the request
            $request->validate([
                                   'current_password'      => 'required|string',
                                   'password'              => 'required|string|min:8|confirmed', // Ensure the new password is confirmed
                                   'password_confirmation' => 'required|string|min:8',
                               ]);

            // Check if the current password is correct
            if (!password_verify($request->current_password, Auth::user()->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            // Update the user's password
            Auth::user()->update(['password' => bcrypt($request->password)]);

            return back()->with('status', 'Password updated successfully.');
        }

        public function list(Request $request): \Inertia\Response
        {

            $query = $request->query('search');

            $users = User::where('username', 'like', '%' . $query . '%')
                         ->orWhere('email', 'like', '%' . $query . '%')
                         ->orWhere('codm_username', 'like', '%' . $query . '%')
                         ->orWhere('phone_number', 'like', '%' . $query . '%')
                         ->paginate(10);

            $users->appends(['search' => $query]);

            return Inertia::render('Views/Super/Accounts/index', [
                'payload' => $users
            ]);
        }

        public function view_user(Request $request, $id): \Inertia\Response
        {
            $user = User::find($id);

            if ($user == null)
                abort('404', 'User not found');

            return Inertia::render('Views/Super/Accounts/view', [
                'account' => $user
            ]);
        }

        public function update_account(Request $request, $id): \Illuminate\Http\RedirectResponse
        {
            $user = User::find($id);
            $role = role::where('name', Auth::user()->role_name)->first();

            if ($user == null)
                abort('404', 'User not found');
            elseif ($role->name != 'Super Admin' && $user->email != Auth::user()->email)
                abort('403', 'You can only update your account');

            Validator::make($request->input(), [
                'username'      => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'email'         => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'codm_username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'phone_number'  => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
                'role_name'     => ['sometimes|required', 'string', 'max:255', Rule::in(['Super Admin', 'Admin', 'Moderator', 'Player', 'Guest'])]
            ])->validated();

            $user->update([
                              'username'      => $request->input('username'),
                              'email'         => $request->input('email'),
                              'codm_username' => $request->input('codm_username'),
                              'phone_number'  => $request->input('phone_number'),
                          ]);

            if ($request->input('role_id'))
                $user->update([
                                  'role_id' => role::where('name', $request->input('role_name'))->first()->id,
                              ]);


            return redirect()->route('accounts.view_user', $user->id)->with('success_message', 'User Updated successfully');;
        }

        #[NoReturn] public function update_password(Request $request, User $user)
        {
            Validator::make($request->input(), [
                'current_password'      => ['required', 'string', 'current_password:web'],
                'password'              => $this->passwordRules(),
                'password_confirmation' => ['required', 'string', 'same:password'],
            ],              [
                                'current_password' => __('The provided password does not match your current password.'),
                            ])->validate();

            dd("validated");

            $user->forceFill([
                                 'password' => bcrypt($request->input('password')),
                             ])->save();
        }

        public function suspend_account(Request $request, $user)
        {
            $active_user = Auth::user();
            $user = User::findOrFail($user);

            if (str_contains(strtolower($active_user->role_name), 'admin')) {
                $user->Active = 0;
                $user->save();
                return [
                    'status'  => "success",
                    'message' => "Account suspended successfully."
                ];
            } else {
                abort(403, 'Unauthorized action.');
            }
        }

        public function unsuspend_account_action(Request $request, $user)
        {
            $active_user = Auth::user();
            $user = User::findOrFail($user);

            if (str_contains(strtolower($active_user->role_name), 'admin')) {
                $user->Active = 1;
                $user->save();
                return [
                    'status'  => "success",
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
