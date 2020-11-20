<?php declare(strict_types=1);

namespace App\Modules\AdminModule\Presenters;

use App\Presenters\BasePresenter;
use Nette;


/**
 * Class AdminBasePresenter
 * @package App\AdminModule\Presenters
 *
 * @property AdminBaseTemplate				$template
 */
abstract class AdminBasePresenter extends BasePresenter
{
	/**
	 * @param mixed $element
	 * @throws Nette\Application\AbortException
	 * @throws Nette\Application\ForbiddenRequestException
	 */
	public function checkRequirements($element): void
	{
		if(!$this->getUser()->isLoggedIn()) {
			$this->flashWarning('messages.security.authRequired', 'messages.security.authRequiredCaption');
			$this->redirect(':Frontend:Sign:in');
		}

		parent::checkRequirements($element);
	}
}