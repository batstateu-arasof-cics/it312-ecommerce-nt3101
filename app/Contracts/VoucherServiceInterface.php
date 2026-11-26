<?php

namespace App\Contracts;

/**
 * Provided by: Vouchers module - unassigned starter code (instructor-owned).
 * apply() handles the seeded WELCOME10 code; full rules are listed in the module README.
 */
interface VoucherServiceInterface
{
    /**
     * The discount amount in pesos for this code and subtotal.
     * Returns 0 when the code is invalid, expired, used up, or below minimum spend.
     */
    public function apply(?string $code, float $subtotal): float;

    /** Records that the code was used on an order. */
    public function redeem(string $code, int $orderId): void;
}
