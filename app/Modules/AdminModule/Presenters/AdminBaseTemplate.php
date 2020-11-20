<?php declare(strict_types=1);

namespace App\Modules\AdminModule\Presenters;

use App\Presenters\BaseTemplate;


/**
 * Class AdminBaseTemplate
 * @package App\AdminModule\Presenters
 */
abstract class AdminBaseTemplate extends BaseTemplate
{
	/** @var AdminBasePresenter */
	public $presenter;
}