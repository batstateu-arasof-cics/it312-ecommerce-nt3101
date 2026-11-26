<?php

namespace App\Modules\Search\Services;

use App\Contracts\SearchServiceInterface;
use App\Modules\Catalog\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchService implements SearchServiceInterface
{
    public function search(string $query, array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $products = Product::active()->with('category');

        if ($query !== '') {
            $products->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        }

        // TODO (Search team): category_id filter
        // TODO (Search team): min_price / max_price filter
        // TODO (Search team): min_rating filter (use ReviewServiceInterface or join reviews once Reviews team merges)
        // TODO (Search team): sort = price_asc | price_desc | newest

        return $products->latest()->paginate($perPage)->withQueryString();
    }
}
