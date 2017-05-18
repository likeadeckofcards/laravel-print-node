<?php

namespace Infernobass7\PrintNode;

use Exception;

class PrinterNotDefinedException extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param string $message
     *
     * @return void
     */
    public function __construct($message = 'Printer was not defined.')
    {
        parent::__construct($message);
    }
}
