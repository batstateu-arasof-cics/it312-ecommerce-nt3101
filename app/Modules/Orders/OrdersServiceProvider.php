<?php

namespace App\Modules\Orders;

use App\Contracts\OrderServiceInterface;
use App\Events\OrderShipped;
use App\Events\PaymentConfirmed;
use App\Modules\Orders\Listeners\MarkOrderPaid;
use App\Modules\Orders\Listeners\MarkOrderShipped;
use App\Modules\Orders\Services\OrderService;
use App\Providers\ModuleServiceProvider;

/** Orders team - Checkout & Orders */
class OrdersServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Orders';

    protected string $viewNamespace = 'orders';

    public $singletons = [
        OrderServiceInterface::class => OrderService::class,
    ];

    protected array $listen = [
        PaymentConfirmed::class => MarkOrderPaid::class,
        OrderShipped::class => MarkOrderShipped::class,
    ];
}
