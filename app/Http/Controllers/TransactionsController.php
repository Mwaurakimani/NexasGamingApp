<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function list_transactions()
    {
        $role = Auth::user()->role->name;
        $transactions = null;
        $view = 'Views/Transactions';


        switch ($role) {
            case 'Super Admin':
                $transactions = [];
                $view = 'Views/Super/Transactions/Transactions';
                break;
            case 'Admin':
                $transactions = [];
                $view = 'Views/Admin/Transactions';
                break;
            case 'Moderator':
                $transactions = [];
                $view = 'Views/Moderators/Transactions';
                break;
            case 'Player':
            case 'Guest':
                $transactions = [];
                $view = 'Views/Players/Transactions';
                break;
            default:
                return redirect()->route('dashboard');
        }

        return Inertia::render($view, [
            'transactions' => $transactions
        ]);
    }
}
