<?php

namespace App\Modules\Inventory;

use App\Contracts\InventoryServiceInterface;
use App\Events\OrderCancelled;
use App\Events\OrderPlaced;
use App\Modules\Inventory\Listeners\DeductStockOnOrder;
use App\Modules\Inventory\Listeners\RestoreStockOnCancel;
use App\Modules\Inventory\Services\InventoryService;
use App\Providers\ModuleServiceProvider;

/** Inventory team - Inventory & Stock */
class InventoryServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Inventory';

    protected string $viewNamespace = 'inventory';

    public $singletons = [
        InventoryServiceInterface::class => InventoryService::class,
    ];

    protected array $listen = [
        OrderPlaced::class => DeductStockOnOrder::class,
        OrderCancelled::class => RestoreStockOnCancel::class,
    ];
}
