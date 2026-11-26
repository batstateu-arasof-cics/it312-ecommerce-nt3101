<?php

namespace App\Modules\Dashboard;

use App\Contracts\ReportServiceInterface;
use App\Modules\Dashboard\Services\ReportService;
use App\Providers\ModuleServiceProvider;

/** Dashboard team - Admin Dashboard & Reports */
class DashboardServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Dashboard';

    protected string $viewNamespace = 'dashboard';

    public $singletons = [
        ReportServiceInterface::class => ReportService::class,
    ];
}
