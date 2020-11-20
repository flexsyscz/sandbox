<?php declare(strict_types=1);

namespace App\Model\Languages;

use App\Model\BaseFacade;


/**
 * Class LanguagesFacade
 * @package App\Model
 *
 * @property-read LanguagesRepository		$repository
 */
final class LanguagesFacade extends BaseFacade
{
	/**
	 * @return LanguagesRepository
	 */
	public function getRepository(): LanguagesRepository
	{
		return $this->orm->languages;
	}
}