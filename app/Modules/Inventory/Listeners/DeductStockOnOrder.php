<?php

namespace App\Modules\Inventory\Listeners;

use App\Contracts\InventoryServiceInterface;
use App\Events\OrderPlaced;

class DeductStockOnOrder
{
    public function __construct(private InventoryServiceInterface $inventory) {}

    public function handle(OrderPlaced $event): void
    {
        $this->inventory->deductStock($event->order->loadMissing('items'));
    }
}
