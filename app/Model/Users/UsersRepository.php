<?php declare(strict_types=1);

namespace App\Model\Users;

use Nextras\Orm\Repository\Repository;


/**
 * Class UsersRepository
 * @package App\Model
 */
final class UsersRepository extends Repository
{
	/**
	 * @return array<string>
	 */
	static function getEntityClassNames() : array
	{
		return [User::class];
	}
}