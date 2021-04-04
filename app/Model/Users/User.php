<?php
declare(strict_types=1);

namespace App\Model\Users;

use Flexsyscz\Universe\Model\EnumWrapper;
use Flexsyscz\Universe\Utils\DateTimeProvider;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;


/**
 * @property 		int         					$id      					{primary}
 * @property		string							$username
 * @property 		string							$password
 * @property 		UserRole						$role						{wrapper EnumWrapper}
 * @property 		string							$firstName
 * @property 		string 							$lastName
 * @property 		DateTimeImmutable				$created
 *
 * @property-read 	string							$displayName				{virtual}
 */
final class User extends Entity
{
	public function onCreate(): void
	{
		parent::onCreate();

		$this->created = DateTimeProvider::now();
	}


	protected function getterDisplayName(): string
	{
		return sprintf('%s %s', $this->firstName, $this->lastName);
	}
}
