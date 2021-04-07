<?php
declare(strict_types=1);

namespace App\Tests;

use Nette;
use Tester;
use Tester\Assert;

require __DIR__ . '/DefaultTestCase.php';


/**
 * Class ExampleTest
 * @package App\Tests
 *
 * @testCase
 */
class ExampleTest extends DefaultTestCase
{
	public function testContainer(): void
	{
		Assert::true(is_array($this->container->getParameters()));
	}
}

$container = DefaultTestCase::getContainer();
(new ExampleTest($container))->run();
