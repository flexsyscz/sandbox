<?php declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


/**
 * Class RouterFactory
 * @package App\Router
 */
final class RouterFactory
{
	use Nette\StaticClass;


	/**
	 * @return RouteList
	 */
	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->withModule('Admin')
			->addRoute('admin/<locale=cs [a-z]{2}>[-<country>]/<presenter>/<action>', 'Dashboard:default');

		$router->withModule('Frontend')
			->addRoute('<locale=cs [a-z]{2}>[-<country>]/<presenter>/<action>', 'Homepage:default');

		return $router;
	}
}