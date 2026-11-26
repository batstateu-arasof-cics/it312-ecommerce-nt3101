<?php

namespace App\Events;

use App\Modules\Catalog\Models\Product;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired by: Inventory team when a product's stock drops to or below its threshold.
 * Listened to by: Dashboard team (dashboard alert), Notifications team (admin email)
 */
class StockLow
{
    use Dispatchable, SerializesModels;

    public function __construct(public Product $product) {}
}
