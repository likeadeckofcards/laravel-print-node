<?php

namespace Infernobass7\PrintNode;

use Exception;

class InvalidCredentialsException extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param string $message
     *
     * @return void
     */
    public function __construct($message = 'Credentials are Invalid.')
    {
        parent::__construct($message);
    }
}
