<?php declare(strict_types=1);

namespace App\Modules\AdminModule\Presenters\Dashboard;

use App\Modules\AdminModule\Presenters;
use Nette;


/**
 * Class DashboardPresenter
 * @package App\AdminModule\Presenters
 *
 * @property DashboardTemplate				$template
 */
final class DashboardPresenter extends Presenters\AdminBasePresenter
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