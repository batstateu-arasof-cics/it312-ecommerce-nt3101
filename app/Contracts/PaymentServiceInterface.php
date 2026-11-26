<?php

namespace App\Contracts;

use App\Modules\Orders\Models\Order;
use App\Modules\Payments\Models\Payment;

/**
 * Provided by: Payments team
 */
interface PaymentServiceInterface
{
    /**
     * Creates the payment record for an order.
     * $method: 'cod' or 'online'. For 'online', the payment's checkout_url is where the customer is sent.
     */
    public function createPayment(Order $order, string $method): Payment;

    /** Handles the gateway's webhook and fires PaymentConfirmed on success. */
    public function handleWebhook(array $payload): void;
}
