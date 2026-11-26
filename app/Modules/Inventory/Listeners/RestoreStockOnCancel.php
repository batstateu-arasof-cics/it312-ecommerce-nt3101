<?php

namespace App\Modules\Inventory\Listeners;

use App\Contracts\InventoryServiceInterface;
use App\Events\OrderCancelled;

class RestoreStockOnCancel
{
    public function __construct(private InventoryServiceInterface $inventory) {}

    public function handle(OrderCancelled $event): void
    {
        $this->inventory->restoreStock($event->order->loadMissing('items'));
    }
}
