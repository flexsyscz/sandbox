<?php declare(strict_types=1);

namespace App\Modules\FrontendModule\Forms;

use App\Forms\FormFactory;
use App\Forms\SignInFormValues;
use Nette;
use Nette\Application\UI\Form;


/**
 * Class SignInFormFactory
 * @package App\FrontendModule\Forms
 */
final class SignInFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;

	/** @var Nette\Security\User */
	private $user;

	/** @var callable */
	private $callback;


	/**
	 * SignInFormFactory constructor.
	 * @param FormFactory $factory
	 * @param Nette\Security\User $user
	 */
	public function __construct(FormFactory $factory, Nette\Security\User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}


	/**
	 * @param callable $callback
	 * @return Form
	 */
	public function create(callable $callback): Form
	{
		$this->callback = $callback;

		$form = $this->factory->create();
		$form->getElementPrototype()->setAttribute('class', 'ajax');

		$form->addText('username', 'app.Sign.in.form.username.label')
			->setRequired('app.Sign.in.form.username.rules.required');

		$form->addPassword('password', 'app.Sign.in.form.password.label')
			->setRequired('app.Sign.in.form.password.rules.required');

		$form->addSubmit('submit', 'app.Sign.in.form.submit.label');

		$form->onSuccess[] = [$this, 'onSuccess'];

		return $form;
	}


	/**
	 * @param Form $form
	 * @param SignInFormValues $values
	 */
	public function onSuccess(Form $form, SignInFormValues $values): void
	{
		try {
			$this->user->login($values->username, $values->password);
			$this->user->setExpiration('+14 days');

			call_user_func($this->callback);

		} catch (Nette\Security\AuthenticationException $e) {
			$form->addError($form->getTranslator()->translate($e->getMessage()));
		}
	}
}