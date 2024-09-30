<?php

namespace App\Http\Controllers\DashboardControllerExtension;

use Inertia\Inertia;
use App\Models\Matches;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait DashboardControllerTraits
{
    public function LoadView(string $view, array $data): \Inertia\Response
    {
        $data['username'] = Auth::user()->username;
        $data['account']['balance'] = Auth::user()->balance;

        $userId = Auth::user()->id;  // or pass user_id directly

        $transactions = DB::table('deposits')
            ->select('id', 'amount', 'status', 'created_at', DB::raw("'deposit' as type"))
            ->where('user_id', $userId)
            ->union(
                DB::table('withdrawals')
                    ->select('id', 'amount', 'status', 'created_at', DB::raw("'withdrawal' as type"))
                    ->where('user_id', $userId)
            )
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
        ;

        $data['account']['transactions'] = $transactions;

        return Inertia::render($view, $data);
    }

    public function GuestPlayerDashboard(): \Inertia\Response
    {
        $view = 'Views/Dashboard';
        $currentMatch = Matches::where('status', 'Active')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->first()
        ;

        return $this->LoadView($view, [
            'currentMatch' => $currentMatch
        ]);
    }

    public function ModeratorDashboard(): \Inertia\Response
    {
        $view = "Views/Moderator/Dashboard";
        return $this->LoadView($view, [

        ]);
    }

    public function AdminDashboard(): \Inertia\Response
    {
        $view = "Views/Admin/Dashboard";
        return $this->LoadView($view, [
        ]);
    }

    public function SuperAdminDashboard(): \Inertia\Response
    {
        $view = "Views/Super/Dashboard";
        return $this->LoadView($view, [

        ]);
    }
}
