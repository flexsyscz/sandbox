<?php declare(strict_types=1);

namespace App\Model\Languages;

use Flexsyscz\Universe\Model\EnumWrapper;
use Nextras\Orm\Entity\Entity;


/**
 * @property 		int         					$id      					{primary}
 * @property 		LanguageCode					$code						{wrapper EnumWrapper}
 * @property 		string							$name
 *
 * @property-read 	string							$short						{virtual}
 */
final class Language extends Entity
{
	/**
	 * @return string
	 */
	protected function getterShort(): string
	{
		return $this->code->getShort();
	}
}