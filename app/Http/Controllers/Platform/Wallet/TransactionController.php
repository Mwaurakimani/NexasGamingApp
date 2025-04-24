<?php

    namespace App\Http\Controllers\Platform\Wallet;

    use App\Models\Transaction;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;

    class TransactionController extends Controller {
        public function index()
        {
            return response()
                ->json(['transactions' =>
                            Transaction::where('user_id', Auth::id())
                                       ->latest()
                                       ->paginate(20)
                       ]);
        }
    }

