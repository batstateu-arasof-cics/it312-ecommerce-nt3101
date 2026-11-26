<?php

namespace App\Modules\Orders\Listeners;

use App\Contracts\OrderServiceInterface;
use App\Events\OrderShipped;
use App\Modules\Orders\Models\Order;

class MarkOrderShipped
{
    public function __construct(private OrderServiceInterface $orders) {}

    public function handle(OrderShipped $event): void
    {
        $order = $this->orders->find($event->shipment->order_id);

        if ($order && $order->canTransitionTo(Order::SHIPPED)) {
            $this->orders->updateStatus($order->id, Order::SHIPPED);
        }
    }
}
