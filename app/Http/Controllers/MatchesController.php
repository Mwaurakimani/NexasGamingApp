<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Mockery\Exception;
use App\Models\Matches;
use Illuminate\Http\Request;
use App\Models\Participants;
use App\Models\Transactions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MatchControllerExtensions\MatchesControllerExtension;
use App\Http\Controllers\MatchControllerExtensions\MatchJoinigControllerExtension;

class MatchesController extends Controller
{

    use MatchesControllerExtension;
    use MatchJoinigControllerExtension;

    public function ListMatches(Request $request): \Inertia\Response
    {
        $role = Auth::user()->role->name;

        if ($role == "Super Admin") {
            $data = $this->admin_list_matches($request);
            return Inertia::render('Views/Super/Matches/index', $data);
        } else {
            $data = $this->player_list_matches($request);
            return Inertia::render('Views/Players/Matches/Matches', $data);
        }
    }

    public function MyMatches(Request $request): \Inertia\Response
    {
        $matches = Matches::whereHas('participants', function ($query) {
            $query->where('user_id', auth()->id()); // Filter by authenticated user's ID
        })
            ->whereIn('status', [
                'Scheduled',
                'Inactive',
                'Starting',
                'Progressing',
                'Tallying',
                'Tallied',
                'Disputed',
                'Completed'
            ])
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10)
        ;

        return Inertia::render('Views/Players/Matches/MyMatchView', [
            'matches' => $matches,
        ]);

    }

    public function OpenMatches(Request $request, $id): \Inertia\Response
    {
        $role = Auth::user()->role->name;

        if ($role == "Super Admin" || $role == "Admin") {
            $matches = Matches::with('participants')->find($id);

            $matches->participants->transform(function ($participant) {

                $user = User::where('id', $participant->user_id)->first();

                $add_on = [
                    "username"      => $user->username,
                    "codm_username" => $user->codm_username,
                ];

                $participantArray = $participant->toArray();

                return array_merge($participantArray, $add_on);
            });

            return Inertia::render('Views/Admin/Matches/UpdateMatch', [
                'match' => $matches
            ]);
        } else {
            $matches = Matches::with('participants')->find($id);

            return Inertia::render('Views/Players/Matches/MatchView', [
                'match' => $matches
            ]);
        }
    }

    public function create(): \Inertia\Response
    {
        return Inertia::render("Views/Admin/Matches/CreateMatch");
    }

    public function store(Request $request)
    {
        // Validate the incoming request...
        $request->validate([
                               'mode'   => 'required|string|in:BRS,BRD,BRQ,1v1,2v2,5v5',  // Ensure 'mode' is one of the allowed values
                               'date'   => 'required|date_format:Y-m-d',                  // Validate 'date' format as YYYY-MM-DD
                               'teams'  => 'required|integer|min:1',                     // 'teams' must be an integer greater than 0
                               'status' => 'required|string|in:Active,Inactive,Pending',// Ensure 'status' is one of the allowed values
                               'time'   => 'required|date_format:H:i',                    // Validate 'time' format as HH:MM
                               'stake'  => 'required|numeric|min:0',                     // 'stake' must be a numeric value greater than or equal to 0
                           ]);

        $match = $request->all();
        $match['moderator_id'] = Auth::user()->id;

        // Create a new match
        $match = Matches::create($match);

        return redirect()->route('matches.list')
            ->with('success', 'Match created successfully')
        ;
    }

    public function edit(Request $request, $match)
    {
        // Validate the incoming request...
        $request->validate([
                               'mode'   => 'required|string|in:BRS,BRD,BRQ,1v1,2v2,5v5',  // Ensure 'mode' is one of the allowed values
                               'date'   => 'required|date_format:Y-m-d',                  // Validate 'date' format as YYYY-MM-DD
                               'teams'  => 'required|integer|min:1',                     // 'teams' must be an integer greater than 0
                               'status' => 'required|string|in:Active,Scheduled,Inactive,Starting,Progressing,Tallying,Tallied,Disputed,Completed',
                               'time'   => 'required|date_format:H:i',                    // Validate 'time' format as HH:MM
                               'stake'  => 'required|numeric|min:0', // 'stake' must be a numeric value greater than or equal to 0
                           ]);

        $match = Matches::find($match);

        if ($request->input('status') == 'Completed') {
            try {
                $mod = User::where('username', 'Super Admin')->first();
                $user_id = $this->getWinner($match);

                $user = User::find($user_id);

                $transfer = Transactions::create([
                                                     'sender_id'        => $mod->id,
                                                     'receiver_id'      => $user_id,
                                                     'amount'           => $match->stake * 0.9,
                                                     'transaction_type' => 'Payout',
                                                     'description'      => 'Payout for Match id' . $match->id,
                                                     'ref'              => null,
                                                     'status'           => 'completed',
                                                 ]);

                $receiver_balance = $user->balance + $match->stake * 0.9;
                $sender_balance = $mod->balance + $match->stake * 0.9;

                $user->update(['balance' => $receiver_balance]);
                $mod->update(['balance' => $sender_balance]);


            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }

        $match->update($request->all());


        return redirect()->back()
            ->with('success', 'Match created successfully')
        ;

    }

    public function eventEdit(Request $request, $match)
    {
        $request->validate([
                               'pace'  => 'nullable|string|in:Normal,Fast,Fast', // Ensure 'pace' is one of the allowed values
                               'notes' => 'nullable|string|max:3000',          // Allow 'notes' to be nullable and limit to 3000 characters
                           ]);

        // If the request
        $match = Matches::find($match);

        $match = $match->update($request->all());

        return redirect()->back()
            ->with('success', 'Match updated successfully')
        ;
    }

    public function get_user_by_name(Request $request)
    {
        $search_term = $request->input('search');

        return User::where('username', 'like', '%' . $search_term . '%')
            ->orWhere('codm_username', 'like', '%' . $search_term . '%')
            ->limit(5) // Limit results to 5
            ->get()
        ;

    }

    public function addUserToMatch(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
                               'username' => 'required|exists:users,username',
                               'matchId'  => 'required|exists:matches,id',
                           ]);

        $user = User::where('username', $request->input('username'))->first();
        $match = Matches::find($request->input('matchId'));

        if (!$user || !$match) abort(404, "User or Match not found");

        if (in_array($user->id, $match->participants->pluck('id')->toArray()))
            abort(403, "Entry already Exist");

        Participants::create([
                                 'user_id'  => $user->id,
                                 'match_id' => $match->id,
                             ]);

        return redirect()->back();
    }

    public function joinMatch(Request $request)
    {
        $match = Matches::find($request->input('matchId'));

        if (!$match)
            abort(404, "Match not found");

        if (in_array(Auth::user()->id, $match->participants->pluck('id')->toArray()))
            abort(403, "You are already in this match");


        switch ($match->mode) {
            case '1v1':
                $this->one_vs_one_join_match($request, $match->id);
                break;
            case '2v2':
                $this->two_vs_two_join_match($request, $match);
                break;
            case '5v5':
                $this->five_vs_five_join_match($request, $match->id);
                break;
            case 'BRS':
                $this->brs_join_match($request, $match);
                break;
            case 'BRD':
                $this->brd_join_match($request, $match->id);
                break;
            case 'BRQ':
                $this->brq_join_match($request, $match->id);
                break;
            default:
                abort(403, "Invalid match mode");
        }
    }

    public function postResults(Request $request, Matches $match)
    {
        $validatedData = $request->validate([
                                                'kills' => 'required|numeric|min:0|max:100000', // Validate kills as a number between 0 and 100,000
                                            ]);

        $participation = $match->participants()->where('user_id', auth()->id())->first();
        $participation->user_score = intval($request->input('kills'));
        $participation->save();

        return redirect()->back()->with('success', 'Scores Updated...');
    }

    private function getWinner($match)
    {
        $participants = $match->participants;
        // Get the participant with the highest user_score
        $winner = $match->participants->sortByDesc('user_score')->first();

        return $winner->user_id;
    }

}
