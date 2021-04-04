<?php
declare(strict_types=1);

namespace App\Presenters;

use App\Model\Languages\Language;
use App\Model\Languages\LanguageCode;
use App\Traits\InjectDateTimeProvider;
use App\Traits\InjectLanguagesFacade;
use App\Traits\InjectLoggedUser;
use Flexsyscz\UI\Messaging\Messages;
use Flexsyscz\Universe\Exceptions\EntityNotFoundException;
use Flexsyscz\Universe\Localization\TranslatedComponent;
use Nette;
use Nette\Application\UI\Presenter;
use Nextras\Orm\Collection\ICollection;


/**
 * Class BasePresenter
 * @package App\Presenters
 *
 * @property BaseTemplate				$template
 */
abstract class BasePresenter extends Presenter
{
	use InjectLanguagesFacade;
	use InjectLoggedUser;
	use InjectDateTimeProvider;
	use TranslatedComponent;
	use Messages;

	/**
	 * @persistent string
	 * @var string
	 */
	public $locale;

	/**
	 * @persistent string|null
	 * @var string|null
	 */
	public $country;

	/** @var ICollection */
	private $languages;

	/** @var Language */
	private $language;


	/**
	 * @throws Nette\Application\BadRequestException
	 */
	public function startup()
	{
		parent::startup();

		try {
			$this->languages = $this->languagesFacade->repository->findAll();
			$language = $this->languages->getBy(['code' => LanguageCode::getByLanguageAndCountry($this->locale, $this->country)]);

			if (!$language instanceof Language) {
				throw new EntityNotFoundException('Language not found in the database.');
			}

			$this->language = $language;
			$this->translatorNamespace->translator->setLanguage($this->language->code->getValue());

		} catch (\TypeError $e) {
			throw new Nette\Application\BadRequestException('Language not found.', 404);

		} catch (EntityNotFoundException $e) {
			throw new Nette\Application\BadRequestException($e->getMessage(), 404);
		}
	}


	protected function beforeRender()
	{
		parent::beforeRender();

		$this->setLayout(__DIR__ . '/templates/@layout.latte');
		$this->template->setTranslator($this->translatorNamespace);

		$this->template->languages = $this->languages;
		$this->template->currentLanguage = $this->language;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->dateTimeProvider = $this->dateTimeProvider;
	}
}
