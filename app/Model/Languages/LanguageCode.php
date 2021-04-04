<?php
declare(strict_types=1);

namespace App\Model\Languages;

use MabeEnum\Enum;


/**
 * Class LanguageCode
 * @package App\Model\Languages
 */
final class LanguageCode extends Enum
{
	public const CS = 'cs_CZ';
	public const EN = 'en_US';


	/**
	 * @param string $directory
	 * @return array<string>
	 */
	public static function getDictionaries(string $directory): array
	{
		$dictionaries = [];
		foreach (self::getConstants() as $code) {
			$dictionaries[$code] = sprintf('%s/%s.neon', $directory, $code);
		}

		return $dictionaries;
	}


	public static function getByLanguageAndCountry(string $language, string $country = null): ?self
	{
		$pattern = sprintf('#^%s_%s$#', $language, ($country ?: '.*'));
		foreach (self::getEnumerators() as $enum) {
			if (preg_match($pattern, $enum->getValue())) {
				return $enum;
			}
		}

		return null;
	}


	public function getShort(): string
	{
		return (string) (explode('_', $this->getValue())[0]);
	}
}
