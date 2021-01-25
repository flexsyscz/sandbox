<?php declare(strict_types=1);

namespace App\Model\Languages;

use MabeEnum\Enum;


/**
 * Class LanguageCode
 * @package App\Model\Languages
 */
final class LanguageCode extends Enum
{
	const CS = 'cs_CZ';
	const EN = 'en_US';


	/**
	 * @return string
	 */
	public static function getDefault(): string
	{
		return self::CS;
	}


	/**
	 * @param string $directory
	 * @return array<string>
	 */
	public static function getDictionaries(string $directory): array
	{
		$dictionaries = [];
		foreach(self::getConstants() as $code) {
			$dictionaries[$code] = sprintf('%s/%s.neon', $directory, $code);
		}

		return $dictionaries;
	}


	/**
	 * @param string $language
	 * @param string|null $country
	 * @return LanguageCode|null
	 */
	public static function getByLanguageAndCountry(string $language, string $country = null): ?LanguageCode
	{
		$pattern = sprintf('#^%s_%s$#', $language, ($country ?: '.*'));
		foreach(LanguageCode::getEnumerators() as $enum) {
			if(preg_match($pattern, $enum->getValue())) {
				return $enum;
			}
		}

		return null;
	}


	/**
	 * @return string
	 */
	public function getShort(): string
	{
		return strval(explode('_', $this->getValue())[0]);
	}
}