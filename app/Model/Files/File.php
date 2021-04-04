<?php
declare(strict_types=1);

namespace App\Model\Files;

use Flexsyscz\Universe\FileSystem\FileObject;
use Flexsyscz\Universe\Utils\DateTimeProvider;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;


/**
 * @property 		int         					$id      					{primary}
 * @property		string							$partition
 * @property 		string							$path
 * @property 		string							$name
 * @property 		int								$size
 * @property 		string							$type
 * @property 		DateTimeImmutable				$created
 * @property 		DateTimeImmutable|null			$updated
 *
 * @property-read 	int								$timestamp					{virtual}
 */
final class File extends Entity
{
	use FileObject;

	public const
		B = 1,
		KB = self::B * 1024,
		MB = self::KB * 1024,
		GB = self::MB * 1024;

	public const
		DEFAULT_MAX_FILE_SIZE = 20,
		DEFAULT_MAX_FILES_IN_BYTES = self::DEFAULT_MAX_FILE_SIZE * self::MB;


	public function onCreate(): void
	{
		parent::onCreate();

		$this->created = DateTimeProvider::now();
	}


	public function onBeforeUpdate(): void
	{
		parent::onAfterUpdate();

		$this->updated = DateTimeProvider::now();
	}


	protected function getterTimestamp(): int
	{
		return $this->updated
			? $this->updated->getTimestamp()
			: $this->created->getTimestamp();
	}
}
