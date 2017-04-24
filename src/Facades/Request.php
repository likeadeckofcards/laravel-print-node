<?php

namespace Infernobass7\PrintNode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class PrintNodeRequestFacade
 * @package Infernobass7\PrintNode
 */
class PrintNodeRequestFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor(){
		return 'Request';
	}
}