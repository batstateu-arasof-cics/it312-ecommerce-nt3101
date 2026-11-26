<?php

namespace App\Modules\Catalog\Services;

use App\Contracts\CatalogServiceInterface;
use App\Modules\Catalog\Models\Product;

class CatalogService implements CatalogServiceInterface
{
    public function getProduct(int $id): ?Product
    {
        return Product::active()->find($id);
    }

    public function isAvailable(int $productId, int $qty): bool
    {
        $product = $this->getProduct($productId);

        return $product !== null && $qty > 0 && $product->stock >= $qty;
    }
}
