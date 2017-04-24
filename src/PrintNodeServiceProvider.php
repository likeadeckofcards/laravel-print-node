<?php

namespace Infernobass7\PrintNode;

use Illuminate\Support\ServiceProvider;

class PrintNodeServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../config/printnode.php' =>config_path('printnode.php')
		]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}
}