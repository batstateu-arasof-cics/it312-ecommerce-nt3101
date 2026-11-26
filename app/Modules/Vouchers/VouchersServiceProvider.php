<?php

namespace App\Modules\Vouchers;

use App\Contracts\VoucherServiceInterface;
use App\Events\OrderPlaced;
use App\Modules\Vouchers\Listeners\RedeemVoucher;
use App\Modules\Vouchers\Services\VoucherService;
use App\Providers\ModuleServiceProvider;

/** Vouchers & Discounts - unassigned starter code */
class VouchersServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Vouchers';

    protected string $viewNamespace = 'vouchers';

    public $singletons = [
        VoucherServiceInterface::class => VoucherService::class,
    ];

    protected array $listen = [
        OrderPlaced::class => RedeemVoucher::class,
    ];
}
