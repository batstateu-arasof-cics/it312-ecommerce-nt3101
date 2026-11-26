<?php

namespace App\Modules\Payments\Http\Controllers;

use App\Contracts\PaymentServiceInterface;
use App\Http\Controllers\Controller;
use App\Modules\Payments\Gateway\GatewayClient;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    /** The gateway posts here. CSRF is disabled for this URI in bootstrap/app.php. */
    public function __invoke(Request $request, PaymentServiceInterface $payments, GatewayClient $gateway)
    {
        // TODO (Payments team, Must 2): reject the request with 401 unless the X-Mock-Signature header
        // matches $gateway->expectedSignature($request->getContent()). Compare with hash_equals().
        // Without this check, anyone could mark an order as paid.

        $payments->handleWebhook($request->json()->all());

        return response()->json(['received' => true]);
    }
}
