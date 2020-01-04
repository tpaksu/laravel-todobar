<?php

namespace TPaksu\TodoBar;

use Illuminate\Support\ServiceProvider;
use TPaksu\TodoBar\Storage\DataStorageInterface;

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
        $this->mergeConfigFrom(__DIR__ . '/config/todobar.php', "todobar");
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
        if (config('todobar.enabled', false) === true) {
            $this->app->make('TPaksu\TodoBar\Controllers\TodoBarController');

            $this->app->singleton(DataStorageInterface::class, function() {
                $storage = config("todobar.storage.engine", Storage\JSONStorage::class);
                $config = config("todobar.storage.params", ["file" => "items.json"]);
                if (class_exists($storage)) {
                    return new $storage($config);
                }
                return new Storage\JSONStorage(["file" => "items.json"]);
            });

            $this->app["router"]->pushMiddlewareToGroup("web", "\TPaksu\TodoBar\Middleware\TodoBarMiddleware");
        }
    }
}
