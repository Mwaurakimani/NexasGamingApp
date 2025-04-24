<?php

namespace App\Http\Controllers\Platform\Game;

use App\Models\Game;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $games = Game::query()
                     ->when($request->search, fn($q) =>
                     $q->where('name', 'like', "%{$request->search}%")
                       ->orWhere('slug', 'like', "%{$request->search}%")
                     )
                     ->orderBy('name')
                     ->paginate(10)
                     ->withQueryString();

        return Inertia::render('Admin/Games/Index', [
            'games' => $games,
            'filters' => $request->only('search'),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Games/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
                                            'name' => 'required|string|max:255',
                                            'slug' => 'required|string|alpha_dash|unique:games',
                                            'category' => 'required|string',
                                            'config' => 'nullable|array',
                                        ]);

        Game::create($validated);

        return redirect()->route('games.index')->with('success', 'Game created.');
    }

    public function show(Game $game)
    {
        return Inertia::render('Admin/Games/Show', ['game' => $game]);
    }

    public function edit(Game $game)
    {
        return Inertia::render('Admin/Games/Edit', ['game' => $game]);
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
                                            'name' => 'required|string|max:255',
                                            'slug' => 'required|string|alpha_dash|unique:games,slug,' . $game->id,
                                            'category' => 'required|string',
                                            'config' => 'nullable|array',
                                        ]);

        $game->update($validated);

        return redirect()->route('games.index')->with('success', 'Game updated.');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->route('games.index')->with('success', 'Game deleted.');
    }
}

