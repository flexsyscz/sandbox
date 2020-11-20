<?php declare(strict_types=1);

namespace App\Modules\FrontendModule\Presenters\Homepage;

use App\Modules\FrontendModule\Presenters;
use Nette;


/**
 * Class HomepagePresenter
 * @package App\FrontendModule\Presenters
 *
 * @property HomepageTemplate				$template
 */
final class HomepagePresenter extends Presenters\FrontendBasePresenter
{
	public function __construct()
	{
		parent::__construct();
	}


	public function actionDefault(): void
	{
	}


	public function renderDefault(): void
	{
	}
}