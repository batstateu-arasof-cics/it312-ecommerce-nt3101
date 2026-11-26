<?php

namespace App\Modules\Vouchers\Listeners;

use App\Contracts\VoucherServiceInterface;
use App\Events\OrderPlaced;

class RedeemVoucher
{
    public function __construct(private VoucherServiceInterface $vouchers) {}

    public function handle(OrderPlaced $event): void
    {
        if ($event->voucherCode) {
            $this->vouchers->redeem($event->voucherCode, $event->order->id);
        }
    }
}
