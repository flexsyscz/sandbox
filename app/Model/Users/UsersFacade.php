<?php declare(strict_types=1);

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
	/**
	 * @return UsersRepository
	 */
	public function getRepository(): UsersRepository
	{
		return $this->orm->users;
	}


	/**
	 * @param User $user
	 * @param string $hash
	 * @return User
	 */
	public function updatePasswordHash(User $user, string $hash): User
	{
		$user->password = $hash;

		$this->orm->users->persistAndFlush($user);
		return $user;
	}
}