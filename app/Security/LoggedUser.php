<?php
declare(strict_types=1);

namespace App\Security;

use App\Model\Users;
use Nette\Security\SimpleIdentity;


/**
 * Class LoggedUser
 * @package App\Security
 *
 * @property-read Users\User	$entity
 */
class LoggedUser extends SimpleIdentity
{
	/** @var Users\User|null */
	private $entity;


	/**
	 * @param Users\User $entity
	 * @return $this
	 */
	public function setEntity(Users\User $entity): self
	{
		$this->entity = $entity;

		return $this;
	}


	public function getEntity(): ?Users\User
	{
		return $this->entity;
	}
}
