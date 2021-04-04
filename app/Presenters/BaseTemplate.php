<?php
declare(strict_types=1);

namespace App\Presenters;

use App\Model\Languages\Language;
use App\Security\LoggedUser;
use Flexsyscz\Universe\Utils\DateTimeProvider;
use Nette;
use Nextras\Orm\Collection\ICollection;


/**
 * Class BaseTemplate
 * @package App\Presenters
 *
 * @method bool isLinkCurrent(string $destination = null, ...$args)
 * @method bool isModuleCurrent(string $module)
 */
abstract class BaseTemplate extends Nette\Bridges\ApplicationLatte\Template
{
	/** @var BasePresenter */
	public $presenter;

	/** @var Nette\Application\UI\Control */
	public $control;

	/** @var Nette\Security\User */
	public $user;

	/** @var string */
	public $baseUrl;

	/** @var string */
	public $basePath;

	/** @var \stdClass[] */
	public $flashes = [];

	/** @var Language */
	public $currentLanguage;

	/** @var ICollection */
	public $languages;

	/** @var LoggedUser */
	public $loggedUser;

	/** @var DateTimeProvider */
	public $dateTimeProvider;
}
