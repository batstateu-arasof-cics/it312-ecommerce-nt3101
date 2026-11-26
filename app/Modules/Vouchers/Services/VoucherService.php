<?php

namespace App\Modules\Vouchers\Services;

use App\Contracts\VoucherServiceInterface;
use App\Modules\Vouchers\Models\Voucher;

class VoucherService implements VoucherServiceInterface
{
    public function apply(?string $code, float $subtotal): float
    {
        if (! $code) {
            return 0;
        }

        $voucher = Voucher::where('code', strtoupper(trim($code)))->where('is_active', true)->first();

        if (! $voucher) {
            return 0;
        }

        // TODO (unassigned): return 0 when expired (expires_at in the past)
        // TODO (unassigned): return 0 when $subtotal < min_spend
        // TODO (unassigned): return 0 when used_count >= usage_limit

        $discount = $voucher->type === 'percent'
            ? $subtotal * ((float) $voucher->value / 100)
            : (float) $voucher->value;

        return round(min($discount, $subtotal), 2); // never more than the subtotal
    }

    public function redeem(string $code, int $orderId): void
    {
        // TODO (unassigned): find the voucher, create a voucher_redemptions row, increment used_count.
        // Wrap it in DB::transaction().
    }
}
