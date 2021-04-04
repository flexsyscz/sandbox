<?php
declare(strict_types=1);

namespace App\Modules\AdminModule\Presenters\Dashboard;

use App\Model\Files\File;
use App\Model\Files\FilesFacade;
use App\Modules\AdminModule\Forms\UploadProfilePhotoFormFactory;
use App\Modules\AdminModule\Presenters;
use Nette;


/**
 * Class DashboardPresenter
 * @package App\AdminModule\Presenters
 *
 * @property DashboardTemplate				$template
 */
final class DashboardPresenter extends Presenters\AdminBasePresenter
{
	/** @var UploadProfilePhotoFormFactory */
	private $uploadProfilePhotoFormFactory;

	/** @var FilesFacade */
	private $filesFacade;

	/** @var File|null */
	private $profilePhoto;


	/**
	 * DashboardPresenter constructor.
	 * @param UploadProfilePhotoFormFactory $uploadProfilePhotoFormFactory
	 * @param FilesFacade $filesFacade
	 */
	public function __construct(UploadProfilePhotoFormFactory $uploadProfilePhotoFormFactory, FilesFacade $filesFacade)
	{
		parent::__construct();

		$this->uploadProfilePhotoFormFactory = $uploadProfilePhotoFormFactory;
		$this->filesFacade = $filesFacade;
	}


	public function actionDefault(): void
	{
		$file = $this->filesFacade->repository->getBy(['partition' => FilesFacade::PARTITION_DATA, 'path' => 'profile.jpg']);
		if ($file instanceof File) {
			$this->profilePhoto = $file;
		}
	}


	public function renderDefault(): void
	{
		$this->template->profilePhoto = $this->profilePhoto;
	}


	protected function createComponentUploadProfilePhotoForm(): Nette\Application\UI\Form
	{
		return $this->uploadProfilePhotoFormFactory->create(function () {
			$this->flashSuccess('profilePhotoSaved');
			$this->redirect('this');
		});
	}
}
