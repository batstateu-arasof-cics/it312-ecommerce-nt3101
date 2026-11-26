<?php

namespace App\Modules\Search;

use App\Contracts\SearchServiceInterface;
use App\Modules\Search\Services\SearchService;
use App\Providers\ModuleServiceProvider;

/** Search team - Search & Filters */
class SearchServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Search';

    protected string $viewNamespace = 'search';

    public $singletons = [
        SearchServiceInterface::class => SearchService::class,
    ];
}
