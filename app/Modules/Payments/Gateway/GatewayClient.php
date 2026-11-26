<?php

namespace App\Modules\Payments\Gateway;

use App\Modules\Payments\Models\Payment;
use Illuminate\Support\Facades\Http;

/**
 * Talks to the payment gateway's API (the mock gateway by default; see /mock-gateway/index.php).
 * Settings: config('services.payment_gateway').
 */
class GatewayClient
{
    /**
     * Creates a checkout session and returns ['id' => 'cs_...', 'checkout_url' => '...', 'status' => 'open'].
     *
     * @throws \Illuminate\Http\Client\RequestException|\Illuminate\Http\Client\ConnectionException
     */
    public function createCheckout(Payment $payment): array
    {
        $config = config('services.payment_gateway');

        return Http::withToken($config['secret'])
            ->acceptJson()
            ->timeout(10)
            ->post(rtrim($config['url'], '/').'/v1/checkouts', [
                'amount' => (float) $payment->amount,
                'reference' => 'PAY-'.$payment->id,
                'success_url' => url('/payments/success'),
                'cancel_url' => url('/payments/failed'),
                'webhook_url' => url('/payments/webhook'),
            ])
            ->throw()
            ->json();
    }

    /** The signature the gateway puts in the X-Mock-Signature header for this raw body. */
    public function expectedSignature(string $rawBody): string
    {
        return hash_hmac('sha256', $rawBody, config('services.payment_gateway.webhook_secret'));
    }
}
