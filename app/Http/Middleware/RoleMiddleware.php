<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;

    class RoleMiddleware
    {
        public function handle(Request $request, Closure $next, string $roles)
        {
            $user = $request->user();
            if (! $user) {
                abort(403, 'Unauthorized');
            }

            // Support multiple roles: "admin|editor"
            $allowed = explode('|', $roles);

            // Compare directly against the `role` column
            if (in_array($user->role, $allowed, true)) {
                return $next($request);
            }

            abort(403, 'Insufficient role');
        }
    }
