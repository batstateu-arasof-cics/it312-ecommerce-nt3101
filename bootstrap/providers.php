<?php

use App\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,

    // One provider per module (see app/Providers/ModuleServiceProvider.php)
    App\Modules\Users\UsersServiceProvider::class,               // Users team
    App\Modules\Catalog\CatalogServiceProvider::class,           // Catalog team
    App\Modules\Search\SearchServiceProvider::class,             // Search team
    App\Modules\Cart\CartServiceProvider::class,                 // Cart team
    App\Modules\Vouchers\VouchersServiceProvider::class,         // unassigned starter code
    App\Modules\Orders\OrdersServiceProvider::class,             // Orders team
    App\Modules\Payments\PaymentsServiceProvider::class,         // Payments team
    App\Modules\Inventory\InventoryServiceProvider::class,       // Inventory team
    App\Modules\Dashboard\DashboardServiceProvider::class,       // Dashboard team
    App\Modules\Notifications\NotificationsServiceProvider::class, // Notifications team
    App\Modules\Shipping\ShippingServiceProvider::class,         // Shipping team
    App\Modules\Reviews\ReviewsServiceProvider::class,           // Reviews team
];
