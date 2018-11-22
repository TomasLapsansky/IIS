<?php

namespace App;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{

		$router = new RouteList;
		$router[] = new Route('/', 'Homepage:default', Route::ONE_WAY);

		// ADMIN

        $router[] = new Route("admin[/<presenter>[/<action>[/<id [0-9]+>]]]", [
            "module" => "Admin",
            "presenter" => "Default",
            "action" => "default"
        ]);

        return $router;
	}
}
