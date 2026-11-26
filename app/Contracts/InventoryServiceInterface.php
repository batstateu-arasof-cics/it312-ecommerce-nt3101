<?php

namespace App\Contracts;

use App\Modules\Orders\Models\Order;
use Illuminate\Support\Collection;

/**
 * Provided by: Inventory team
 */
interface InventoryServiceInterface
{
    public function deductStock(Order $order): void;

    public function restoreStock(Order $order): void;

    /** Products at or below their low-stock threshold. */
    public function lowStock(): Collection;
}
