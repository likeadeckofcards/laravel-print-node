<?php

namespace Infernobass7\PrintNode;

use Exception;

class InvalidPrinterSettingUsedException extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param string $message
     *
     * @return void
     */
    public function __construct($message = 'The value used in a Print Job\'s setting is not valid for the printer chosen.')
    {
        parent::__construct($message);
    }
}
