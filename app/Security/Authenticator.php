<?php declare(strict_types=1);

namespace App\Security;

use App\Model\Users\User;
use App\Model\Users\UsersFacade;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nextras\Dbal\Drivers\Exception\DriverException;
use Nextras\Orm\Entity\ToArrayConverter;


/**
 * Class Authenticator
 * @package App\Security
 */
class Authenticator implements IAuthenticator
{
	/** @var UsersFacade */
	private $usersFacade;

	/** @var Passwords */
	private $passwords;


	/**
	 * Authenticator constructor.
	 * @param UsersFacade $usersFacade
	 * @param Passwords $passwords
	 */
	public function __construct(UsersFacade $usersFacade, Passwords $passwords)
	{
		$this->usersFacade = $usersFacade;
		$this->passwords = $passwords;
	}


	/**
	 * @param array<string> $credentials
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	function authenticate(array $credentials): IIdentity
	{
		list($username, $password) = $credentials;

		$user = $this->usersFacade->repository->getBy(['username' => $username]);
		if(!$user instanceof User) {
			throw new AuthenticationException('messages.security.userNotFound', self::IDENTITY_NOT_FOUND);
		}

		if(!$this->passwords->verify($password, $user->password)) {
			throw new AuthenticationException('messages.security.invalidCredential', self::INVALID_CREDENTIAL);
		}

		try {
			if ($this->passwords->needsRehash($user->password)) {
				$this->usersFacade->updatePasswordHash($user, $this->passwords->hash($password));
			}
		} catch(DriverException $e) {
			throw new AuthenticationException('messages.security.unexpectedError', self::FAILURE, $e);
		}

		unset($password);

		$data = $user->toArray(ToArrayConverter::RELATIONSHIP_AS_ID);
		unset($data['password']);
		unset($data['role']);

		return new Identity($user->id, [$user->role->getName()], $data);
	}
}