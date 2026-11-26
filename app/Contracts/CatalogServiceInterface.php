<?php

namespace App\Contracts;

use App\Modules\Catalog\Models\Product;

/**
 * Provided by: Catalog team
 */
interface CatalogServiceInterface
{
    /** An active product, or null if it does not exist or is deactivated. */
    public function getProduct(int $id): ?Product;

    /** True when the product is active and has at least $qty in stock. */
    public function isAvailable(int $productId, int $qty): bool;
}
