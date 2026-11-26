<?php

namespace App\Modules\Search\Http\Controllers;

use App\Contracts\SearchServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, SearchServiceInterface $search)
    {
        $query = trim((string) $request->query('q', ''));

        // TODO (Search team): validate and pass the filter inputs
        $filters = [];

        $products = $search->search($query, $filters);

        return view('search::index', compact('products', 'query'));
    }
}
