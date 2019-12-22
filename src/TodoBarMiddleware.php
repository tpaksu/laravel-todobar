<?php

namespace TPaksu\TodoBar;

use Closure;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Container\Container;

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
        $this->todobar->inject($response);

        return $response;
    }
}
