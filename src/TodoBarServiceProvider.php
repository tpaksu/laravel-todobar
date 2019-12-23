<?php

namespace TPaksu\TodoBar;

use Illuminate\Support\ServiceProvider;
use TPaksu\TodoBar\Storage\DataStorageInterface;
use TPaksu\TodoBar\Storage\JSONStorage;

class TodoBarServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'laravel-todobar');
        $this->publishes([
            __DIR__ . '/config/todobar.php' => config_path('todobar.php'),
            __DIR__ . '/resources/views' => base_path('resources/views/tpaksu/todobar'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('TPaksu\TodoBar\Controllers\TodoBarController');

        $this->app->singleton(DataStorageInterface::class, function () {
            return new JSONStorage("items.json");
        });

        $this->app["router"]->pushMiddlewareToGroup("web", "\TPaksu\TodoBar\Middleware\TodoBarMiddleware");
    }

}
