<?php declare(strict_types=1);

namespace App\Modules\AdminModule\Presenters\Dashboard;

use App\Modules\AdminModule\Presenters;

/**
 * Class DashboardTemplate
 * @package App\AdminModule\Presenters
 */
final class DashboardTemplate extends Presenters\AdminBaseTemplate
{
	/** @var DashboardPresenter */
	public $presenter;
}