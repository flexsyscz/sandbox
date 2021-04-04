<?php
declare(strict_types=1);

namespace App\Forms;

use Flexsyscz\UI\Forms\Renderer;
use Nette;
use Nette\Application\UI\Form;


/**
 * Class FormFactory
 * @package App\Forms
 */
final class FormFactory
{
	public function create(): Form
	{
		$form = new Form;
		$form->onRender[] = [Renderer::class, 'makeBootstrap5'];

		return $form;
	}
}
