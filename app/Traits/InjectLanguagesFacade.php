<?php
declare(strict_types=1);

namespace App\Traits;

use App\Model\Languages\LanguagesFacade;


/**
 * Trait InjectLanguagesFacade
 * @package App\Traits
 */
trait InjectLanguagesFacade
{
	/** @var LanguagesFacade */
	private $languagesFacade;


	public function injectLanguagesFacade(LanguagesFacade $languagesFacade): void
	{
		$this->languagesFacade = $languagesFacade;
	}
}
