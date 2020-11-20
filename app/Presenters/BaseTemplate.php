<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Languages\Language;
use App\Security\LoggedUser;
use Flexsyscz\Universe\Utils\DateTimeProvider;
use Nette\Bridges\ApplicationLatte\Template;
use Nextras\Orm\Collection\ICollection;


/**
 * Class BaseTemplate
 * @package App\Presenters
 */
abstract class BaseTemplate extends Template
{
	/** @var BasePresenter */
	public $presenter;

	/** @var Language */
	public $currentLanguage;

	/** @var ICollection */
	public $languages;

	/** @var LoggedUser */
	public $loggedUser;

	/** @var DateTimeProvider */
	public $dateTimeProvider;
}