<?php
namespace catsalad\V1\Exception;

use Exception;

class BadRequestException extends Exception
{
	public function __construct()
	{
		parent::__construct("Unsatisfied request content.");
	}
}