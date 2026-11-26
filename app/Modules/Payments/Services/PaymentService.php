<?php

namespace App\Modules\Payments\Services;

use App\Contracts\PaymentServiceInterface;
use App\Modules\Orders\Models\Order;
use App\Modules\Payments\Gateway\GatewayClient;
use App\Modules\Payments\Models\Payment;
use Illuminate\Support\Facades\Log;
use Throwable;

class PaymentService implements PaymentServiceInterface
{
    public function __construct(private GatewayClient $gateway) {}

    public function createPayment(Order $order, string $method): Payment
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $method,
            'status' => Payment::PENDING,
            'amount' => $order->total,
        ]);

        if ($method === 'online') {
            try {
                $checkout = $this->gateway->createCheckout($payment);

                $payment->update([
                    'gateway_reference' => $checkout['id'],
                    'checkout_url' => $checkout['checkout_url'],
                ]);
            } catch (Throwable $e) {
                // Gateway down: the order stays pending and the customer stays on our site.
                Log::warning('Could not create checkout', ['payment' => $payment->id, 'error' => $e->getMessage()]);
            }
        }

        return $payment;
    }

    public function handleWebhook(array $payload): void
    {
        // The controller has already checked the signature (TODO Payments team, Must 2).
        // TODO (Payments team, Must 3):
        // 1. Find the payment: Payment::where('gateway_reference', $payload['data']['id'])
        // 2. Ignore it if the payment is already paid or failed (gateways may send the same webhook twice)
        // 3. 'checkout.paid'   -> status = paid, paid_at = now(), then PaymentConfirmed::dispatch($payment)
        //    'checkout.failed' -> status = failed
        Log::info('Payment webhook received', $payload);
    }
}
