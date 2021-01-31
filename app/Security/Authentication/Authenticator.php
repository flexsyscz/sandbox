<?php declare(strict_types=1);

namespace App\Security\Authentication;

use App\Model\Users\User;
use App\Model\Users\UsersFacade;
use Flexsyscz\Universe\Localization\TranslatedComponent;
use Nette;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;
use Nextras\Dbal\Drivers\Exception\DriverException;
use Nextras\Orm\Entity\ToArrayConverter;


/**
 * Class Authenticator
 * @package App\Security\Authentication
 */
class Authenticator implements Nette\Security\Authenticator
{
	use TranslatedComponent;

	/** @var string */
	public const TRANSLATOR_NAMESPACE = 'authenticator';

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
	 * @param string $user
	 * @param string $password
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	function authenticate(string $user, string $password): IIdentity
	{
		$user = $this->usersFacade->repository->getBy(['username' => $user]);
		if(!$user instanceof User) {
			throw new AuthenticationException($this->translatorNamespace->translate('userNotFound'), self::IDENTITY_NOT_FOUND);
		}

		if(!$this->passwords->verify($password, $user->password)) {
			throw new AuthenticationException($this->translatorNamespace->translate('invalidCredential'), self::INVALID_CREDENTIAL);
		}

		try {
			if ($this->passwords->needsRehash($user->password)) {
				$this->usersFacade->updatePasswordHash($user, $this->passwords->hash($password));
			}
		} catch(DriverException $e) {
			throw new AuthenticationException($this->translatorNamespace->translate('unexpectedError'), self::FAILURE, $e);
		}

		unset($password);

		$data = $user->toArray(ToArrayConverter::RELATIONSHIP_AS_ID);
		unset($data['password']);
		unset($data['role']);

		return new SimpleIdentity($user->id, [$user->role->getName()], $data);
	}
}