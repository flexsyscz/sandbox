<?php
declare(strict_types=1);

namespace App\Modules\AdminModule\Forms;

use Nette\Http\FileUpload;
use Nette\Utils\ArrayHash;


/**
 * Class UploadProfilePhotoFormValues
 * @package App\Modules\FrontendModule\Forms
 */
final class UploadProfilePhotoFormValues extends ArrayHash
{
	/** @var FileUpload */
	public $photo;
}
