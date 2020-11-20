<?php declare(strict_types=1);

namespace App\Forms;

use Nette\Utils\ArrayHash;


/**
 * Class SignInFormValues
 * @package App\Forms
 */
final class SignInFormValues extends ArrayHash
{
	/** @var string */
	public $username;

	/** @var string */
	public $password;
}