<?php

namespace App\Modules\Users;

use App\Contracts\UserServiceInterface;
use App\Modules\Users\Services\UserService;
use App\Providers\ModuleServiceProvider;

/** Users team - Users & Auth */
class UsersServiceProvider extends ModuleServiceProvider
{
    protected string $module = 'Users';

    protected string $viewNamespace = 'users';

    public $singletons = [
        UserServiceInterface::class => UserService::class,
    ];
}
