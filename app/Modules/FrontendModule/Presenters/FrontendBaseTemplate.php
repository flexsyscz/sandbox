<?php
declare(strict_types=1);

namespace App\Modules\FrontendModule\Presenters;

use App\Presenters\BaseTemplate;


/**
 * Class FrontendBaseTemplate
 * @package App\FrontendModule\Presenters
 */
abstract class FrontendBaseTemplate extends BaseTemplate
{
	/** @var FrontendBasePresenter */
	public $presenter;
}
