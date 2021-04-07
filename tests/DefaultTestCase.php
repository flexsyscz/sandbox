<?php
declare(strict_types=1);

namespace App\Tests;

use Nette;
use Tester;
use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';


abstract class DefaultTestCase extends Tester\TestCase
{
	/** @var Nette\DI\Container */
	protected $container;


	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}


	public static function getContainer(): Nette\DI\Container
	{
		return \App\Bootstrap::bootForTests()
			->createContainer();
	}


	public function setUp()
	{
	}
}
