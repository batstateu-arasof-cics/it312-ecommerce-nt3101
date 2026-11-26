<?php

namespace App\Modules\Payments;

use App\Contracts\PaymentServiceInterface;
use App\Modules\Payments\Services\PaymentService;
use App\Providers\ModuleServiceProvider;

/** Payments team - Payments */
class PaymentsServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Payments';

    protected string $viewNamespace = 'payments';

    public $singletons = [
        PaymentServiceInterface::class => PaymentService::class,
    ];
}
