<?php
declare(strict_types=1);

namespace App\Model;

use App\Model\Languages\LanguagesRepository;
use App\Model\Users\UsersRepository;
use Nextras\Orm\Model\Model;


/**
 * Class Orm
 * @package App\Model
 *
 * @property-read UsersRepository							$users
 * @property-read LanguagesRepository						$languages
 */
final class Orm extends Model
{
}
