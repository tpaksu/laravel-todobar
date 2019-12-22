<?php

namespace TPaksu\TodoBar;

use Illuminate\Support\ServiceProvider;

class TodoBarServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-todobar');
        $this->publishes([
            __DIR__.'/config/todobar.php' => config_path('todobar.php'),
            __DIR__.'/resources/views' => base_path('resources/views/tpaksu/todobar'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('TPaksu\TodoBar\TodoBarController');
        $this->app["router"]->pushMiddlewareToGroup("web", "\TPaksu\TodoBar\TodoBarMiddleware");
    }

}
