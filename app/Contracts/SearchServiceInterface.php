<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Provided by: Search team
 *
 * Supported $filters keys: category_id, min_price, max_price, min_rating, sort (price_asc, price_desc, newest)
 */
interface SearchServiceInterface
{
    public function search(string $query, array $filters = [], int $perPage = 12): LengthAwarePaginator;
}
