<?php

namespace Phredeye\Reflex\Facades;

use Illuminate\Support\Facades\Facade;

class Reflex extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'reflex';
    }
}
