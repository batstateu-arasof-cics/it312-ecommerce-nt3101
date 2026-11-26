<?php

namespace App\Modules\Catalog;

use App\Contracts\CatalogServiceInterface;
use App\Modules\Catalog\Services\CatalogService;
use App\Providers\ModuleServiceProvider;

/** Catalog team - Product Catalog */
class CatalogServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Catalog';

    protected string $viewNamespace = 'catalog';

    public $singletons = [
        CatalogServiceInterface::class => CatalogService::class,
    ];
}
