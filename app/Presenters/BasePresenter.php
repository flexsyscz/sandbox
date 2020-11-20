<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Languages\Language;
use App\Model\Languages\LanguageCode;
use App\Traits\DateTimeProviderInjectionTrait;
use App\Traits\LanguagesFacadeInjectionTrait;
use App\Traits\LoggedUserInjectionTrait;
use App\Traits\TranslatorInjectionTrait;
use Flexsyscz\UI\Messaging\PresenterFlashesTrait;
use Flexsyscz\Universe\Exceptions\EntityNotFoundException;
use Nette;
use Nette\Application\UI\Presenter;


/**
 * Class BasePresenter
 * @package App\Presenters
 *
 * @property BaseTemplate				$template
 */
abstract class BasePresenter extends Presenter
{
	use PresenterFlashesTrait;
	use TranslatorInjectionTrait;
	use LanguagesFacadeInjectionTrait;
	use LoggedUserInjectionTrait;
	use DateTimeProviderInjectionTrait;

	/**
	 * @persistent string
	 * @var string
	 */
	public $lang;

	/**
	 * @persistent string|null
	 * @var string|null
	 */
	public $country;


	/**
	 * @throws Nette\Application\BadRequestException
	 */
	public function beforeRender()
	{
		try {
			$languages = $this->languagesFacade->repository->findAll();
			$currentLanguage = $languages->getBy(['code' => LanguageCode::getByLanguageAndCountry($this->lang, $this->country)]);

			if(!$currentLanguage instanceof Language) {
				throw new EntityNotFoundException('Language not found in the database.');
			}

			$this->translator->setLanguage($currentLanguage->code->getValue());

		} catch(\TypeError $e) {
			throw new Nette\Application\BadRequestException('Language not found.', 404);

		} catch(EntityNotFoundException $e) {
			throw new Nette\Application\BadRequestException($e->getMessage(), 404);
		}

		$this->setLayout(__DIR__ . '/templates/@layout.latte');
		$this->template->setTranslator($this->translator);

		$this->template->languages = $languages;
		$this->template->currentLanguage = $currentLanguage;
		$this->template->loggedUser = $this->loggedUser;
		$this->template->dateTimeProvider = $this->dateTimeProvider;

		if($this->isAjax()) {
			$this->redrawControl('header');
			$this->redrawControl('main');
			$this->redrawControl('footer');
		}

		parent::beforeRender();
	}
}