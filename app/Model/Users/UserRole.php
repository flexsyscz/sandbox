<?php
declare(strict_types=1);

namespace App\Model\Users;

use MabeEnum\Enum;


/**
 * Class UserRole
 * @package App\Model
 */
final class UserRole extends Enum
{
	public const USER = 'user';
	public const ADMINISTRATOR = 'admin';
}
