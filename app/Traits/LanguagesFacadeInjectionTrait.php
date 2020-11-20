<?php declare(strict_types=1);

namespace App\Traits;

use App\Model\Languages\LanguagesFacade;


/**
 * Trait LanguagesFacadeInjectionTrait
 * @package App\Traits
 */
trait LanguagesFacadeInjectionTrait
{
	/** @var LanguagesFacade */
	private $languagesFacade;


	/**
	 * @param LanguagesFacade $languagesFacade
	 */
	public function injectLanguagesFacade(LanguagesFacade $languagesFacade): void
	{
		$this->languagesFacade = $languagesFacade;
	}
}