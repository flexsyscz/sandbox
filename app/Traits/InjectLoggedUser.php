<?php
declare(strict_types=1);

namespace App\Traits;

use App\Security\LoggedUser;


/**
 * Trait InjectLoggedUser
 * @package App\Traits
 */
trait InjectLoggedUser
{
	/** @var LoggedUser */
	protected $loggedUser;


	public function injectLoggedUser(LoggedUser $loggedUser): void
	{
		$this->loggedUser = $loggedUser;
	}
}
