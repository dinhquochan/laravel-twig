<?php

namespace DinhQuocHan\LaravelTwig;

use Illuminate\Support\Facades\Facade;

class LaravelTwigFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
