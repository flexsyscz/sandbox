<?php
declare(strict_types=1);

namespace App\Model\Files;

use App\Model\BaseFacade;
use App\Model\Orm;
use Flexsyscz\Universe\FileSystem\FileManager;
use Flexsyscz\Universe\FileSystem\Receiver;
use Flexsyscz\Universe\FileSystem\Uploads\Container;
use Nette\Http\FileUpload;
use Nette\Utils\Image;


/**
 * Class FilesFacade
 * @package App\Model
 *
 * @property-read FilesRepository		$repository
 */
final class FilesFacade extends BaseFacade
{
	public const PARTITION_DATA = 'data';

	/** @var FileManager */
	private $fileManager;

	/** @var Receiver */
	private $receiver;


	/**
	 * FilesFacade constructor.
	 * @param Orm $orm
	 * @param FileManager $fileManager
	 * @param Receiver $receiver
	 */
	public function __construct(Orm $orm, FileManager $fileManager, Receiver $receiver)
	{
		parent::__construct($orm);

		$this->fileManager = $fileManager->use(self::PARTITION_DATA);
		$this->receiver = $receiver;
	}


	public function getRepository(): FilesRepository
	{
		return $this->orm->files;
	}


	public function saveProfilePhoto(FileUpload $photo): void
	{
		$this->receiver->save($photo, function (Container $container) {
			$image = $container->getOptimizedImage(256, 256, Image::EXACT);
			$name = 'profile.jpg';
			$path = $this->fileManager->absolutePath($name);
			$image->save($path, 90, Image::JPEG);

			$file = $this->orm->files->getBy(['partition' => self::PARTITION_DATA, 'path' => $name]);
			if (!$file instanceof File) {
				$file = new File;
			}

			$file->partition = self::PARTITION_DATA;
			$file->path = $name;
			$file->name = $name;
			$file->size = filesize($path);
			$file->type = mime_content_type($path);

			$this->orm->files->persistAndFlush($file);
		});
	}
}
