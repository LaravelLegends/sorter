<?php

namespace LaravelLegends\Sorter;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * 
 * 
 * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>
 */

class Facade extends BaseFacade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Sorter::class;
    }
}
