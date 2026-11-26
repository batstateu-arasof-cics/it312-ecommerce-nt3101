<?php

namespace App\Events;

use App\Modules\Orders\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired by: Orders team when an order is cancelled.
 * Listened to by: Inventory team (restore stock), Notifications team (cancellation email)
 */
class OrderCancelled
{
    use Dispatchable, SerializesModels;

    public function __construct(public Order $order) {}
}
