<?php

namespace Elfeffe\Medialibrary\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Elfeffe\Medialibrary\Medialibrary
 */
class Medialibrary extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Elfeffe\Medialibrary\Medialibrary::class;
    }
}
