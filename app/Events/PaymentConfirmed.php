<?php

namespace App\Events;

use App\Modules\Payments\Models\Payment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Fired by: Payments team when the gateway confirms a payment.
 * Listened to by: Orders team (set order to paid), Notifications team (receipt email)
 */
class PaymentConfirmed
{
    use Dispatchable, SerializesModels;

    public function __construct(public Payment $payment) {}
}
