<?php declare(strict_types=1);

namespace App\Forms;

use Flexsyscz\UI\Forms\Renderer;
use Flexsyscz\Universe\Localization\Translator;
use Nette;
use Nette\Application\UI\Form;


/**
 * Class FormFactory
 * @package App\Forms
 */
final class FormFactory
{
	/** @var Translator */
	private $translator;


	/**
	 * FormFactory constructor.
	 * @param Translator $translator
	 */
	public function __construct(Translator $translator)
	{
		$this->translator = $translator;
	}


	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form();
		$form->setTranslator($this->translator)
			->onRender[] = [Renderer::class, 'makeBootstrap5'];

		return $form;
	}
}