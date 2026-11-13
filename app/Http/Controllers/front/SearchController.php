<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\news\NewsModel;
use App\Models\notice\NoticeModel;
use App\Models\page\createpage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = trim((string) $request->input('query', ''));
        $query = mb_substr($query, 0, 100);

        $results = [
            'notices' => collect(),
            'news'    => collect(),
            'pages'   => collect(),
        ];

        if ($query !== '' && mb_strlen($query) >= 2) {
            $corpus = Cache::remember('public_search_corpus', 120, function () {
                return [
                    'notices' => NoticeModel::select(['id', 'topic', 'page_url'])->latest()->limit(500)->get()->toArray(),
                    'news'    => NewsModel::select(['id', 'topic', 'page_url'])->latest()->limit(500)->get()->toArray(),
                    'pages'   => createpage::select(['id', 'page_name', 'page_url'])->latest()->limit(500)->get()->toArray(),
                ];
            });

            $filter = static function (array $items, string $field) use ($query) {
                return collect($items)
                    ->filter(fn (array $item) => isset($item[$field]) && mb_stripos((string) $item[$field], $query) !== false)
                    ->take(20)
                    ->values();
            };

            $results = [
                'notices' => $filter($corpus['notices'] ?? [], 'topic'),
                'news'    => $filter($corpus['news'] ?? [], 'topic'),
                'pages'   => $filter($corpus['pages'] ?? [], 'page_name'),
            ];
        }

        $page_title = $query !== '' ? "অনুসন্ধান: {$query}" : 'অনুসন্ধান';

        return view('search.results', compact('results', 'query', 'page_title'));
    }
}
