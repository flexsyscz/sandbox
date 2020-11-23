<?php declare(strict_types=1);

namespace App\Traits;

use Flexsyscz\Universe\Utils\DateTimeProvider;


/**
 * Trait DateTimeProviderInjectionTrait
 * @package App\Traits
 */
trait DateTimeProviderInjectionTrait
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