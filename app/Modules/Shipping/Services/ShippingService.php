<?php

namespace App\Modules\Shipping\Services;

use App\Contracts\ShippingServiceInterface;
use App\Modules\Shipping\Models\Shipment;
use App\Modules\Users\Models\Address;

class ShippingService implements ShippingServiceInterface
{
    /** Used when there is no address or no matching rate. */
    public const DEFAULT_FEE = 150.00;

    public function getShippingFee(?Address $address): float
    {
        // TODO (Shipping team): look up shipping_rates by $address->province, then by $address->region,
        // and fall back to DEFAULT_FEE. Seed rates for at least Batangas, Metro Manila, Cavite, Laguna.
        // TODO (Shipping team): free shipping above a subtotal (needs a coordinated interface change with Orders team)
        return self::DEFAULT_FEE;
    }

    public function getTracking(int $orderId): ?Shipment
    {
        return Shipment::where('order_id', $orderId)->first();
    }
}
