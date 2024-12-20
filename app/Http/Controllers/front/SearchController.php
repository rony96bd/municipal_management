<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search across multiple models or tables
        $results = [
            'users' => \App\Models\User::where('name', 'LIKE', "%{$query}%")->get(),
        ];

        // Check if any results exist
        $foundResults = array_filter($results, fn($collection) => $collection->isNotEmpty());

        if (!empty($foundResults)) {
            return view('search.results', compact('results', 'query'));
        }

        // Redirect to Google if no results
        return redirect()->away("https://www.google.com/search?q=" . urlencode($query));
    }

}
