<?php declare(strict_types=1);

namespace App;

use Nette\Configurator;


/**
 * Class Bootstrap
 * @package App
 */
class Bootstrap
{
	/**
	 * @return Configurator
	 */
	public static function boot(): Configurator
	{
		$configurator = new Configurator;

		$configurator->setDebugMode(true); // enable for your remote IP
		$configurator->enableTracy(__DIR__ . '/../log');

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory(__DIR__ . '/../temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator
			->addConfig(__DIR__ . '/config/common.neon')
			->addConfig(__DIR__ . '/config/local.neon')
			->addConfig(__DIR__ . '/config/modules/frontend.neon')
			->addConfig(__DIR__ . '/config/modules/admin.neon');

		return $configurator;
	}


	/**
	 * @return Configurator
	 */
	public static function bootForTests(): Configurator
	{
		$configurator = self::boot();
		\Tester\Environment::setup();
		return $configurator;
	}
}