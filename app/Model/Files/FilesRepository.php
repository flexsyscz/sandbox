<?php
declare(strict_types=1);

namespace App\Model\Files;

use Nextras\Orm\Repository\Repository;


/**
 * Class FilesRepository
 * @package App\Model
 */
final class FilesRepository extends Repository
{
	/**
	 * @return string[]
	 */
	public static function getEntityClassNames(): array
	{
		return [File::class];
	}
}
