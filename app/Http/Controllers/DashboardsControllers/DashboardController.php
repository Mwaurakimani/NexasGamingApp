<?php

namespace App\Http\Controllers\DashboardsControllers;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardControllerExtension\DashboardControllerTraits;

class DashboardController extends Controller
{
    use DashboardControllerTraits;
    public function index(): \Illuminate\Foundation\Application|\Inertia\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        return match ($user->role) {
            'Guest', 'Player' => $this->GuestPlayerDashboard(),
            'Moderator'       => $this->ModeratorDashboard(),
            'Admin'          => $this->AdminDashboard(),
            'Super Admin'      => $this->SuperAdminDashboard(),
            default           => redirect('/')->with('error', 'Unauthorized dashboard access.')
        };
    }


























//return Inertia::render('Dashboard',[
//'dataset' => $this->getDataset()
//]);






//    public function index(): \Illuminate\Foundation\Application|\Inertia\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
//    {
//        $role = Auth::user()->role;
//
//        $matchCondition = ['Guest', 'Player', 'Moderator', 'Admin', 'Super Admin'];
//
//        if (in_array($role, $matchCondition)) {
//            return match ($role) {
//                'Player', 'Guest' => $this->GuestPlayerDashboard(),
//                'Moderator' => $this->ModeratorDashboard(),
//                'Admin' => $this->AdminDashboard(),
//                'Super Admin' => $this->SuperAdminDashboard(),
//                default => redirect('/')->with('error', 'You do not have permission to access this page.'),
//            };
//        } else {
//            return redirect('/')->with('error', 'You do not have permission to access this page.');
//        }
//    }

}
