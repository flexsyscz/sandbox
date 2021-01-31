<?php declare(strict_types=1);

namespace App\Traits;

use Flexsyscz\Universe\Utils\DateTimeProvider;


/**
 * Trait InjectDateTimeProvider
 * @package App\Traits
 */
trait InjectDateTimeProvider
{
	/** @var DateTimeProvider */
	protected $dateTimeProvider;


	/**
	 * @param DateTimeProvider $dateTimeProvider
	 */
	public function injectDateTimeProvider(DateTimeProvider $dateTimeProvider): void
	{
		$this->dateTimeProvider = $dateTimeProvider;
	}
}