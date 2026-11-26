<?php

namespace App\Modules\Reviews\Services;

use App\Contracts\ReviewServiceInterface;
use App\Modules\Reviews\Models\Review;

class ReviewService implements ReviewServiceInterface
{
    public function getAverageRating(int $productId): ?float
    {
        $average = Review::where('product_id', $productId)->where('is_approved', true)->avg('rating');

        return $average === null ? null : round((float) $average, 1);
    }
}
