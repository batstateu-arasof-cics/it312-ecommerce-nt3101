<?php

namespace App\Modules\Notifications;

use App\Contracts\NotificationServiceInterface;
use App\Events\OrderPlaced;
use App\Modules\Notifications\Listeners\SendOrderPlacedEmail;
use App\Modules\Notifications\Services\NotificationService;
use App\Providers\ModuleServiceProvider;

/** Notifications team - Notifications */
class NotificationsServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Notifications';

    protected string $viewNamespace = 'notifications';

    public $singletons = [
        NotificationServiceInterface::class => NotificationService::class,
    ];

    protected array $listen = [
        OrderPlaced::class => SendOrderPlacedEmail::class,
        // TODO (Notifications team): PaymentConfirmed, OrderCancelled, OrderShipped, StockLow
    ];
}
