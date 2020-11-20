<?php declare(strict_types=1);

namespace App\Traits;

use Flexsyscz\Universe\Localization\Translator;


/**
 * Trait TranslatorInjectionTrait
 * @package App\Traits
 */
trait TranslatorInjectionTrait
{
	/** @var Translator */
	private $translator;


	/**
	 * @param Translator $translator
	 */
	public function injectTranslator(Translator $translator): void
	{
		$this->translator = $translator;
	}
}