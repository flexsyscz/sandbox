<?php declare(strict_types=1);

namespace App\Model\Languages;

use Nextras\Orm\Repository\Repository;


/**
 * Class LanguagesRepository
 * @package App\Model
 */
final class LanguagesRepository extends Repository
{
	/**
	 * @return array<string>
	 */
	static function getEntityClassNames() : array
	{
		return [Language::class];
	}
}