<?php

namespace App\Contracts;

use App\Models\User;

/**
 * Provided by: Notifications team
 *
 * Templates: order_placed, payment_confirmed, order_cancelled, order_shipped, stock_low
 */
interface NotificationServiceInterface
{
    public function send(User $user, string $template, array $data = []): void;
}
