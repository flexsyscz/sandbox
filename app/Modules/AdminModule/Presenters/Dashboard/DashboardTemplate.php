<?php
declare(strict_types=1);

namespace App\Modules\AdminModule\Presenters\Dashboard;

use App\Model\Files\File;
use App\Modules\AdminModule\Presenters;
use Flexsyscz\Universe\FileSystem\FileManager;

/**
 * Class DashboardTemplate
 * @package App\AdminModule\Presenters
 */
final class DashboardTemplate extends Presenters\AdminBaseTemplate
{
	/** @var DashboardPresenter */
	public $presenter;

	/** @var File|null */
	public $profilePhoto;
}
