<?php

namespace TPaksu\TodoBar\Middleware;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Http\Response;
use TPaksu\TodoBar\Controllers\TodoBarController;

class TodoBarMiddleware {

    /**
     * Create a new middleware instance.
     *
     * @param  Container $container
     * @param  LaravelDebugbar $debugbar
     */
    public function __construct(Container $container, TodoBarController $todobar)
    {
        $this->container = $container;
        $this->todobar = $todobar;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $this->todobar->inject($response);
        }

        return $response;
    }
}
