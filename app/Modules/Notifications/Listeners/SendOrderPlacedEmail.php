<?php

namespace App\Modules\Notifications\Listeners;

use App\Contracts\NotificationServiceInterface;
use App\Events\OrderPlaced;

class SendOrderPlacedEmail
{
    public function __construct(private NotificationServiceInterface $notifications) {}

    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        $this->notifications->send($order->user, 'order_placed', [
            'order_id' => $order->id,
            'order_number' => $order->number(),
            'total' => number_format((float) $order->total, 2),
        ]);
    }
}
