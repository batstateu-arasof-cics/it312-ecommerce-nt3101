<?php

namespace App\Modules\Reviews;

use App\Contracts\ReviewServiceInterface;
use App\Modules\Reviews\Services\ReviewService;
use App\Providers\ModuleServiceProvider;

/** Reviews team - Reviews & Ratings */
class ReviewsServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Reviews';

    protected string $viewNamespace = 'reviews';

    public $singletons = [
        ReviewServiceInterface::class => ReviewService::class,
    ];
}
