<?php

namespace Infernobass7\PrintNode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class PrintNodeRequestFacade.
 */
class Request extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Request';
    }
}
