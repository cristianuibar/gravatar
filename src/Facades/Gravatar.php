<?php namespace Uibar\Gravatar\Facades;

use Illuminate\Support\Facades\Facade;

class Gravatar extends Facade
{

    /**
     * Get the facade accessor.
     *
     * @return      string      Facade accessor
     */
    protected static function getFacadeAccessor()
    {
        return 'gravatar';
    }

}
