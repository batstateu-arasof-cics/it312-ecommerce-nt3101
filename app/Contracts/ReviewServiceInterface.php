<?php

namespace App\Contracts;

/**
 * Provided by: Reviews team
 */
interface ReviewServiceInterface
{
    /** Average of approved ratings (1-5), or null when there are none. */
    public function getAverageRating(int $productId): ?float;
}
