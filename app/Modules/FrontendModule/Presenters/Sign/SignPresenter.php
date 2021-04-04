<?php
declare(strict_types=1);

namespace App\Modules\FrontendModule\Presenters\Sign;

use App\Modules\FrontendModule\Forms\SignInFormFactory;
use App\Modules\FrontendModule\Presenters\FrontendBasePresenter;
use App\Utils\Message;
use Nette;


/**
 * Class SignPresenter
 * @package App\FrontendModule\Presenters
 *
 * @property SignTemplate				$template
 */
final class SignPresenter extends FrontendBasePresenter
{
	/** @var SignInFormFactory */
	private $signInFormFactory;


	/**
	 * SignPresenter constructor.
	 * @param SignInFormFactory $signInFormFactory
	 */
	public function __construct(SignInFormFactory $signInFormFactory)
	{
		parent::__construct();

		$this->signInFormFactory = $signInFormFactory;
	}


	public function actionIn(): void
	{
	}


	public function renderIn(): void
	{
	}


	protected function createComponentSignInForm(): Nette\Application\UI\Form
	{
		return $this->signInFormFactory->create(function () {
			$this->redirect(':Admin:Dashboard:');
		});
	}


	/**
	 * @param bool $clear
	 * @throws Nette\Application\AbortException
	 */
	public function actionOut(bool $clear = false): void
	{
		$this->getUser()->logout($clear);
		$this->redirect('in');
	}
}
