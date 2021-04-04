<?php
declare(strict_types=1);

namespace App\Modules\AdminModule\Forms;

use App\Forms\FormFactory;
use App\Model\Files\File;
use App\Model\Files\FilesFacade;
use Flexsyscz\Universe\Localization\TranslatedComponent;
use Nette;
use Nette\Application\UI\Form;


final class UploadProfilePhotoFormFactory
{
	use Nette\SmartObject;
	use TranslatedComponent;

	/** @var FormFactory */
	private $factory;

	/** @var FilesFacade */
	private $filesFacade;

	/** @var callable */
	private $callback;


	/**
	 * UploadProfilePhotoFormFactory constructor.
	 * @param FormFactory $factory
	 * @param FilesFacade $filesFacade
	 */
	public function __construct(FormFactory $factory, FilesFacade $filesFacade)
	{
		$this->factory = $factory;
		$this->filesFacade = $filesFacade;
	}


	public function create(callable $callback): Form
	{
		$this->callback = $callback;

		$form = $this->factory->create()
			->setTranslator($this->translatorNamespace);

		$form->addUpload('photo', 'photo.label')
			->setRequired('photo.rules.required')
			->addRule($form::MAX_FILE_SIZE, sprintf($this->ns('photo.rules.maxSize'), File::DEFAULT_MAX_FILE_SIZE), File::DEFAULT_MAX_FILES_IN_BYTES);

		$form->addSubmit('submit', 'submit.label');

		$form->onSuccess[] = [$this, 'onSuccess'];

		return $form;
	}


	public function onSuccess(Form $form, UploadProfilePhotoFormValues $values): void
	{
		if ($values->photo->isOk()) {
			if ($values->photo->isImage()) {
				$this->filesFacade->saveProfilePhoto($values->photo);
				call_user_func($this->callback);

			} else {
				$form->addError('photo.errors.notImage');
			}
		} else {
			$form->addError('photo.errors.default');
		}
	}
}
