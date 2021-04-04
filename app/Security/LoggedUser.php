<?php
declare(strict_types=1);

namespace App\Security;

use App\Model\Users;
use Nette\Security\User;
use Nette\SmartObject;


/**
 * Class LoggedUser
 * @package App\Security
 *
 * @property-read User			$user
 * @property-read Users\User	$entity
 */
class LoggedUser
{
	use SmartObject;

	/** @var User */
	private $user;

	/** @var Users\UsersFacade */
	private $usersFacade;

	/** @var Users\User|null */
	private $entity;


	/**
	 * LoggedUser constructor.
	 * @param User $user
	 * @param Users\UsersFacade $usersFacade
	 */
	public function __construct(User $user, Users\UsersFacade $usersFacade)
	{
		$this->user = $user;
		$this->usersFacade = $usersFacade;
		$this->entity = null;

		$identity = $user->getIdentity();
		if ($identity) {
			$id = $identity->getId();
			if ($id) {
				$entity = $this->usersFacade->repository->getById($user->identity->getId());
				if ($entity instanceof Users\User) {
					$this->entity = $entity;
				}
			}
		}
	}


	public function getUser(): User
	{
		return $this->user;
	}


	public function getEntity(): ?Users\User
	{
		return $this->entity;
	}
}
