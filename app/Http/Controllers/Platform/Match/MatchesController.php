<?php

    namespace App\Http\Controllers\Platform\Match;


    use App\Models\Matches;
    use App\Models\Wallet;
    use App\Models\Transaction;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;
    use Inertia\Inertia;
    use App\Http\Controllers\Controller;

    class MatchesController extends Controller {
        public function index(Request $request)
        {
            $matches = Matches::with(['game', 'matchType', 'participants.user'])
                              ->when($request->status, fn($q) => $q->where('status', $request->status))
                              ->latest()
                              ->paginate(10)
                              ->withQueryString();

            return Inertia::render('Admin/Matches/Index', [
                'matches' => $matches,
                'filters' => $request->only('status'),
            ]);
        }

        public function create()
        {
            return Inertia::render('Admin/Matches/Create');
        }

        public function store(Request $request)
        {
            $data = $request->validate([
                                           'game_id'       => 'required|exists:games,id',
                                           'match_type_id' => 'required|exists:match_types,id',
                                           'stake'         => 'required|numeric|min:1',
                                           'timer'         => 'required|integer|min:1',
                                           'config'        => 'nullable|array',
                                       ]);

            $user = Auth::user();
            $wallet = Wallet::firstOrCreate(['user_id' => $user->id]);

            if ($wallet->balance < $data['stake']) {
                return redirect()->back()->withErrors(['stake' => 'Insufficient balance for this stake.']);
            }

            $match = Matches::create([
                                         'id'            => Str::uuid(),
                                         'game_id'       => $data['game_id'],
                                         'match_type_id' => $data['match_type_id'],
                                         'stake'         => $data['stake'],
                                         'payout'        => $data['stake'] * 1.8,
                                         'service_fee'   => $data['stake'] * 0.2,
                                         'timer'         => $data['timer'],
                                         'config'        => $data['config'] ?? null,
                                     ]);

            $match->participants()->create([
                                               'user_id' => $user->id,
                                               'role'    => 'player',
                                           ]);

            $wallet->decrement('balance', $data['stake']);
            Transaction::create([
                                    'user_id'  => $user->id,
                                    'type'     => 'debit',
                                    'amount'   => $data['stake'],
                                    'reason'   => 'Match challenge creation',
                                    'match_id' => $match->id,
                                ]);

            return redirect()->route('matches.show', $match->id)->with('success', 'Match created.');
        }

        public function show(Matches $match)
        {
            return Inertia::render('Admin/Matches/Show', [
                'match' => $match->load(['game', 'matchType', 'participants.user', 'logs']),
            ]);
        }

        public function destroy(Matches $match)
        {
            $match->delete();
            return redirect()->route('matches.index')->with('success', 'Match deleted.');
        }
    }

