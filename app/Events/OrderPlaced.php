<?php

namespace App\Events;

use App\Modules\Orders\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired by: Orders team after an order is created.
 * Listened to by: Vouchers stub (redeem voucher), Inventory team (deduct stock), Notifications team (email), Shipping team (create shipment)
 */
class OrderPlaced
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Order $order,
        public ?string $voucherCode = null,
    ) {}
}
