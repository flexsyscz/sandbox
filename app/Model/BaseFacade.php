<?php
declare(strict_types=1);

namespace App\Model;


use Nette\SmartObject;

/**
 * Class BaseFacade
 * @package App\Model
 */
abstract class BaseFacade
{
	use SmartObject;

	/** @var Orm */
	protected $orm;


	/**
	 * BaseFacade constructor.
	 * @param Orm $orm
	 */
	public function __construct(Orm $orm)
	{
		$this->orm = $orm;
	}
}
