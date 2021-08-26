<?php

namespace App\Larapid\Facades;

use Illuminate\Support\Facades\Facade;

class Larapid extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Larapid\Larapid::class;
    }
}
