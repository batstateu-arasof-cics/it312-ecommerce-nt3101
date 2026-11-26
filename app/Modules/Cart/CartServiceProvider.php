<?php

namespace App\Modules\Cart;

use App\Contracts\CartServiceInterface;
use App\Modules\Cart\Services\CartService;
use App\Providers\ModuleServiceProvider;

/** Cart team - Cart & Wishlist */
class CartServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Cart';

    protected string $viewNamespace = 'cart';

    public $singletons = [
        CartServiceInterface::class => CartService::class,
    ];
}
