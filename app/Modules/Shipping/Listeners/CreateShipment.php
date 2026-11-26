<?php

namespace App\Modules\Shipping\Listeners;

use App\Events\OrderPlaced;

class CreateShipment
{
    public function handle(OrderPlaced $event): void
    {
        // TODO (Shipping team): create a Shipment for $event->order with status 'preparing'
    }
}
