<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\User;
    use Inertia\Inertia;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Platform\Classes\Users\Roles;
    use App\Platform\Classes\Users\UserStatus;
    use App\Actions\Fortify\PasswordValidationRules;
    use App\Http\Requests\Admin\UpdateUserRoleRequest;

    class UsersController extends Controller {
        use PasswordValidationRules;

        public function index(Request $request)
        {
            $users = User::query()
                         ->when($request->search, fn($q) => $q->where('username', 'like', "%{$request->search}%"))
                         ->when($request->role, fn($q) => $q->where('role', $request->role))
                         ->orderByDesc('id')
                         ->paginate(15)
                         ->withQueryString();

            // Dynamic role counts
            $roleCounts = collect(Roles::cases())->mapWithKeys(function ($role) {
                return [$role->value => User::where('role', $role->value)->count()];
            });

            return Inertia::render('Admin/Users', [
                'users'   => $users,
                'filters' => $request->only(['search', 'role']),
                'stats'   => array_merge(
                    [
                        'total'     => User::count(),
                        'active'    => User::where('is_active', UserStatus::Active->value)->count(),
                        'inactive'  => User::where('is_active', UserStatus::Inactive->value)->count(),
                        'suspended' => User::where('is_active', UserStatus::Suspended->value)->count(),
                    ],
                    $roleCounts->toArray())
            ]);
        }

        public function show(User $user)
        {
            return Inertia::render('Admin/Users/View', [
                'user'  => $user,
                'stats' => [
                    'games_played' => 42,
                    'win_rate'     => 60,
                    'rating'       => 4.3,
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

        public function update(UpdateUserRoleRequest $request, User $user)
        {
            $user->update($request->validated());

            return redirect()->route('admin.users.show', [
                'user' => $user->id
            ])->with('success', 'User updated.');
        }
    }
