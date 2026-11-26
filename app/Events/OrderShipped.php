<?php

namespace App\Events;

use App\Modules\Shipping\Models\Shipment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired by: Shipping team when an admin marks a shipment as shipped.
 * Listened to by: Orders team (set order to shipped), Notifications team (tracking email)
 */
class OrderShipped
{
    use Dispatchable, SerializesModels;

    public function __construct(public Shipment $shipment) {}
}
