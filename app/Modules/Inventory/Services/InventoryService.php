<?php

namespace App\Modules\Inventory\Services;

use App\Contracts\InventoryServiceInterface;
use App\Modules\Catalog\Models\Product;
use App\Modules\Inventory\Models\StockMovement;
use App\Modules\Orders\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InventoryService implements InventoryServiceInterface
{
    public function deductStock(Order $order): void
    {
        DB::transaction(function () use ($order) {
            foreach ($order->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                if (! $product) {
                    continue;
                }

                $product->decrement('stock', min($item->quantity, $product->stock));

                StockMovement::create([
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'change' => -$item->quantity,
                    'reason' => 'sale',
                ]);

                // TODO (Inventory team, Must 2): after the transaction, StockLow::dispatch($product) for every product
                // whose stock is now <= config('inventory.low_stock_threshold')
            }
        });
    }

    public function restoreStock(Order $order): void
    {
        // TODO (Inventory team, Must 1): add each item's quantity back and record a 'cancel' movement.
        // Run it only once per order. Hint: if StockMovement::where('order_id', $order->id)
        //     ->where('reason', 'cancel')->exists(), the order was already restored - do nothing.
    }

    public function lowStock(): Collection
    {
        return Product::active()
            ->where('stock', '<=', config('inventory.low_stock_threshold'))
            ->orderBy('stock')
            ->get();
    }
}
