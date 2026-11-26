<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Base class for every module's provider (instructor-owned).
 *
 * Each module has its own provider in app/Modules/<Module>/<Module>ServiceProvider.php.
 * It loads that module's routes.php, views/ and database/migrations/ automatically,
 * binds its service to its contract ($singletons) and registers its event listeners ($listen).
 * Teams only edit their own provider, never this file.
 */
abstract class ModuleServiceProvider extends ServiceProvider
{
    /** Folder name under app/Modules, e.g. 'Cart'. */
    protected string $module;

    /** Views are used as view('<namespace>::file'), e.g. view('cart::index'). */
    protected string $viewNamespace;

    /** Interface => implementation. Laravel binds these automatically. */
    public $singletons = [];

    /** Event class => listener class or list of listener classes. */
    protected array $listen = [];

    public function boot(): void
    {
        $path = app_path('Modules/'.$this->module);

        if (file_exists($path.'/routes.php')) {
            Route::middleware('web')->group($path.'/routes.php');
        }

        if (is_dir($path.'/views')) {
            $this->loadViewsFrom($path.'/views', $this->viewNamespace);
        }

        if (is_dir($path.'/database/migrations')) {
            $this->loadMigrationsFrom($path.'/database/migrations');
        }

        foreach ($this->listen as $event => $listeners) {
            foreach ((array) $listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }
}
