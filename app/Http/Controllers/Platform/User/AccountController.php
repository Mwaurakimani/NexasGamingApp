<?php

    namespace App\Http\Controllers\Platform\User;

    use Inertia\Inertia;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;

    class AccountController extends Controller
    {
        /**
         * Show the user's profile overview.
         */
        public function index(): \Inertia\Response
        {
            $user = Auth::user();

            return Inertia::render('Account/Profile', [
                'user' => $user,
            ]);
        }

        /**
         * Show the form for editing the profile.
         */
        public function edit(): \Inertia\Response
        {
            $user = Auth::user();

            return Inertia::render('Account/EditProfile', [
                'user' => $user,
            ]);
        }

        /**
         * Update the profile in storage.
         */
        public function update(Request $request): \Illuminate\Http\RedirectResponse
        {
            $user = Auth::user();

            $validated = $request->validate([
                                                'username'      => ['required', 'string', 'max:50'],
                                                'email'         => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
                                                'phone_number'  => ['nullable', 'string', 'max:20'],
                                            ]);

            $user->update($validated);

            return redirect()->route('account.profile')->with('success', 'Profile updated.');
        }

        public function editPassword(): \Inertia\Response
        {
            return Inertia::render('Account/ChangePassword');
        }

        public function updatePassword(Request $request): \Illuminate\Http\RedirectResponse
        {
            $request->validate([
                                   'current_password' => ['required', 'current_password'],
                                   'password' => ['required', 'confirmed', 'min:8'],
                               ]);

            $request->user()->update([
                                         'password' => bcrypt($request->password),
                                     ]);

            return redirect()->route('account.profile')->with('success', 'Password updated.');
        }

        public function disable(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
        {
            $request->user()->update(['is_active' => \App\Platform\Classes\Users\UserStatus::Inactive->value]);

            auth()->logout();
            return redirect('/')->with('success', 'Your account has been disabled.');
        }
    }
