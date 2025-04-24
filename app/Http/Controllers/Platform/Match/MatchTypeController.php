<?php

    namespace App\Http\Controllers\Platform\Match;


    use App\Models\MatchType;
    use Illuminate\Http\Request;
    use Inertia\Inertia;
    use App\Http\Controllers\Controller;

    class MatchTypeController extends Controller {
        public function index(Request $request)
        {
            $types = MatchType::query()
                              ->when($request->search, fn($q) => $q
                                  ->where('name', 'like', "%{$request->search}%")
                                  ->orWhere('slug', 'like', "%{$request->search}%")
                              )
                              ->orderBy('name')
                              ->paginate(10)
                              ->withQueryString();

            return Inertia::render('Admin/MatchTypes/Index', [
                'types'   => $types,
                'filters' => $request->only('search'),
            ]);
        }

        public function create()
        {
            return Inertia::render('Admin/MatchTypes/Create');
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                                                'name'          => 'required|string|max:255',
                                                'slug'          => 'required|string|alpha_dash|unique:match_types',
                                                'min_players'   => 'required|integer|min:1',
                                                'max_players'   => 'required|integer|min:1|gte:min_players',
                                                'config_schema' => 'nullable|array',
                                                'description'   => 'nullable|string',
                                            ]);

            MatchType::create($validated);

            return redirect()->route('match-types.index')->with('success', 'Match type created.');
        }

        public function show(MatchType $matchType)
        {
            return Inertia::render('Admin/MatchTypes/Show', ['type' => $matchType]);
        }

        public function edit(MatchType $matchType)
        {
            return Inertia::render('Admin/MatchTypes/Edit', ['type' => $matchType]);
        }

        public function update(Request $request, MatchType $matchType)
        {
            $validated = $request->validate([
                                                'name'          => 'required|string|max:255',
                                                'slug'          => 'required|string|alpha_dash|unique:match_types,slug,' . $matchType->id,
                                                'min_players'   => 'required|integer|min:1',
                                                'max_players'   => 'required|integer|min:1|gte:min_players',
                                                'config_schema' => 'nullable|array',
                                                'description'   => 'nullable|string',
                                            ]);

            $matchType->update($validated);

            return redirect()->route('match-types.index')->with('success', 'Match type updated.');
        }

        public function destroy(MatchType $matchType)
        {
            $matchType->delete();

            return redirect()->route('match-types.index')->with('success', 'Match type deleted.');
        }
    }
