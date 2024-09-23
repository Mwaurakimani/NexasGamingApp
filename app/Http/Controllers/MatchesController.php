<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Participants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MatchesController extends Controller
{

    public function ListMatches(Request $request): \Inertia\Response
    {
        $role = Auth::user()->role->name;

        if ($role == "Super Admin") {
            $data = $this->admin_list_matches($request);
            return Inertia::render('Views/Super/Matches/index', [
                'matches' => $data['matches']
            ]);
        } else {
            return Inertia::render('Views/Matches');
        }
    }

    public function OpenMatches(Request $request, $id): \Inertia\Response
    {
        $role = Auth::user()->role->name;

        if ($role == "Super Admin" || $role == "Admin") {
            $matches = Matches::with('participants')->find($id);

            $matches->participants->transform(function ($participant) {

                $user = User::where('id',$participant->user_id)->first();

                $add_on = [
                    "username" => $user->username,
                    "codm_username" =>$user->codm_username,
                ];

                $participantArray = $participant->toArray();

                return array_merge($participantArray, $add_on);
            });

            return Inertia::render('Views/Admin/Matches/UpdateMatch', [
                'match' => $matches
            ]);
        } else {
            return Inertia::render('Views/Players/MatchView');
        }
    }

    public function create()
    {
        return Inertia::render("Views/Admin/Matches/CreateMatch");
    }

    public function store(Request $request)
    {
        // Validate the incoming request...
        $request->validate([
            'mode' => 'required|string|in:BRS,BRD,BRQ,1v1,2v2,5v5',  // Ensure 'mode' is one of the allowed values
            'date' => 'required|date_format:Y-m-d',                  // Validate 'date' format as YYYY-MM-DD
            'teams' => 'required|integer|min:1',                     // 'teams' must be an integer greater than 0
            'status' => 'required|string|in:Active,Inactive,Pending',// Ensure 'status' is one of the allowed values
            'time' => 'required|date_format:H:i',                    // Validate 'time' format as HH:MM
            'stake' => 'required|numeric|min:0',                     // 'stake' must be a numeric value greater than or equal to 0
        ]);


        $match = $request->all();
        $match['moderator_id'] = Auth::user()->id;

        // Create a new match
        $match = Matches::create($match);

        return redirect()->route('matches.list')
            ->with('success', 'Match created successfully');
    }

    public function edit(Request $request, $match)
    {
        // Validate the incoming request...
        $request->validate([
            'mode' => 'required|string|in:BRS,BRD,BRQ,1v1,2v2,5v5',  // Ensure 'mode' is one of the allowed values
            'date' => 'required|date_format:Y-m-d',                  // Validate 'date' format as YYYY-MM-DD
            'teams' => 'required|integer|min:1',                     // 'teams' must be an integer greater than 0
            'status' => 'required|string|in:Active,Inactive,Pending',// Ensure 'status' is one of the allowed values
            'time' => 'required|date_format:H:i',                    // Validate 'time' format as HH:MM
            'stake' => 'required|numeric|min:0', // 'stake' must be a numeric value greater than or equal to 0
        ]);

        $match = Matches::find($match);

        $match = $match->update($request->all());

        return redirect()->back()
            ->with('success', 'Match created successfully');

    }

    public function eventEdit(Request $request, $match)
    {
        $request->validate([
            'pace' => 'nullable|string|in:Normal,Fast,Fast', // Ensure 'pace' is one of the allowed values
            'notes' => 'nullable|string|max:3000',          // Allow 'notes' to be nullable and limit to 3000 characters
        ]);

        // If the request
        $match = Matches::find($match);

        $match = $match->update($request->all());

        return redirect()->back()
            ->with('success', 'Match updated successfully');
    }

    public function admin_list_matches($request)
    {
        $match = Matches::paginate(2);

        return [
            'matches' => $match
        ];
    }

    public function get_user_by_name(Request $request)
    {
        $search_term = $request->input('search');

        return User::where('username', 'like', '%' . $search_term . '%')
            ->orWhere('codm_username', 'like', '%' . $search_term . '%')
            ->limit(5) // Limit results to 5
            ->get();

    }

    public function addUserToMatch(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'matchId' => 'required|exists:matches,id',
        ]);

        $username = $request->input('username');
        $user = User::where('username', $username)->first();
        $match = Matches::find($request->input('matchId'));

        if (!$user || !$match)
            abort(404, "User or Match not found");

        if(in_array($user->id, $match->participants->pluck('id')->toArray()))
            abort(403,"Entry already Exist");

        $participation = Participants::create([
            'user_id' => $user->id,
            'match_id' => $match->id,
        ]);

        return redirect()->back();
    }
}
