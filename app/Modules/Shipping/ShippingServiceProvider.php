<?php

namespace App\Modules\Shipping;

use App\Contracts\ShippingServiceInterface;
use App\Events\OrderPlaced;
use App\Modules\Shipping\Listeners\CreateShipment;
use App\Modules\Shipping\Services\ShippingService;
use App\Providers\ModuleServiceProvider;

/** Shipping team - Shipping & Tracking */
class ShippingServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Shipping';

    protected string $viewNamespace = 'shipping';

    public $singletons = [
        ShippingServiceInterface::class => ShippingService::class,
    ];

    protected array $listen = [
        OrderPlaced::class => CreateShipment::class,
    ];
}
