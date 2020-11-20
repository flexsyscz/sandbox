<?php declare(strict_types=1);

namespace App\Extensions;

use Nette;
use Nette\DI\CompilerExtension;


/**
 * Class ModelExtension
 * @package App\Extensions
 */
class ModelExtension extends CompilerExtension
{
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$loader = new Nette\Loaders\RobotLoader();
		$loader->addDirectory(__DIR__ . '/../Model')
			->setTempDirectory(__DIR__ . '/../../temp/model')
			->refresh();

		foreach($loader->getIndexedClasses() as $className => $classPath) {
			if(preg_match('#(.*)Facade$#', $className, $matches)) {
				if(isset($matches[1]) && !preg_match('#Base$#', $matches[1])) {
					$name = explode("\\", $matches[1]);
					$builder->addDefinition($this->prefix(sprintf('facades.%s', Nette\Utils\Strings::firstLower(array_pop($name)))))
						->setFactory($className);
				}
			}
		}

	}
}