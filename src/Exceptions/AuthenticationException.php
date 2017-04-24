<?php

namespace Infernobass7\PrintNode;

use Exception;

class AuthenticationException extends Exception
{
	/**
	 * Create a new authentication exception.
	 *
	 * @param  string  $message
	 * @return void
	 */
	public function __construct($message = 'Unauthenticated.')
	{
		parent::__construct($message);
	}
}
