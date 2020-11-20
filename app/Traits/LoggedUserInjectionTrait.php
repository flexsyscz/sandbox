<?php declare(strict_types=1);

namespace App\Traits;

use App\Security\LoggedUser;


/**
 * Trait LoggedUserInjectionTrait
 * @package App\Traits
 */
trait LoggedUserInjectionTrait
{
	/** @var LoggedUser */
	private $loggedUser;


	/**
	 * @param LoggedUser $loggedUser
	 */
	public function injectLoggedUser(LoggedUser $loggedUser): void
	{
		$this->loggedUser = $loggedUser;
	}
}