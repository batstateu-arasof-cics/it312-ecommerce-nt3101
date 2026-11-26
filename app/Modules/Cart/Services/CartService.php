<?php

namespace App\Modules\Cart\Services;

use App\Contracts\CartServiceInterface;
use App\Modules\Cart\Models\CartItem;
use Illuminate\Support\Collection;

class CartService implements CartServiceInterface
{
    public function getItems(int $userId): Collection
    {
        return CartItem::with('product')->where('user_id', $userId)->get();
    }

    public function getSubtotal(int $userId): float
    {
        return (float) $this->getItems($userId)->sum(fn (CartItem $item) => $item->lineTotal());
    }

    public function clear(int $userId): void
    {
        CartItem::where('user_id', $userId)->delete();
    }
}
