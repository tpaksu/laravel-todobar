<?php

namespace TPaksu\TodoBar\Facade;

use Illuminate\Support\Facades\Facade;

class TodoBar extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'todobar';
    }
}
