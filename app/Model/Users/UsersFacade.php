<?php
declare(strict_types=1);

namespace App\Model\Users;

use App\Model\BaseFacade;


/**
 * Class UsersFacade
 * @package App\Model
 *
 * @property-read UsersRepository		$repository
 */
final class UsersFacade extends BaseFacade
{
	public function getRepository(): UsersRepository
	{
		return $this->orm->users;
	}


	public function updatePasswordHash(User $user, string $hash): User
	{
		$user->password = $hash;

		$this->orm->users->persistAndFlush($user);
		return $user;
	}
}
