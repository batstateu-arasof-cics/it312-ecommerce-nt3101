<?php

namespace App\Contracts;

use App\Modules\Shipping\Models\Shipment;
use App\Modules\Users\Models\Address;

/**
 * Provided by: Shipping team
 */
interface ShippingServiceInterface
{
    /** Shipping fee in pesos for the address. A null address gets the default rate. */
    public function getShippingFee(?Address $address): float;

    public function getTracking(int $orderId): ?Shipment;
}
