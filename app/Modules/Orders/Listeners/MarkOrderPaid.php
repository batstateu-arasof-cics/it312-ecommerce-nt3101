<?php

namespace App\Modules\Orders\Listeners;

use App\Contracts\OrderServiceInterface;
use App\Events\PaymentConfirmed;
use App\Modules\Orders\Models\Order;

class MarkOrderPaid
{
    public function __construct(private OrderServiceInterface $orders) {}

    public function handle(PaymentConfirmed $event): void
    {
        $order = $this->orders->find($event->payment->order_id);

        if ($order && $order->canTransitionTo(Order::PAID)) {
            $this->orders->updateStatus($order->id, Order::PAID);
        }
    }
}
