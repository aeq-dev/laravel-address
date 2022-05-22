<?php

namespace Bkfdev\Addressable\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelAddress extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-address';
    }
}
