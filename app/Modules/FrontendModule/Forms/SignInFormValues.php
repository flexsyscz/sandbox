<?php
declare(strict_types=1);

namespace App\Modules\FrontendModule\Forms;

use Nette\Utils\ArrayHash;


/**
 * Class SignInFormValues
 * @package App\Modules\FrontendModule\Forms
 */
final class SignInFormValues extends ArrayHash
{
	/** @var string */
	public $username;

	/** @var string */
	public $password;
}
