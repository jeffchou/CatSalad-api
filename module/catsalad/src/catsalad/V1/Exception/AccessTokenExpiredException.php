<?php
namespace catsalad\V1\Exception;

use Exception;

class AccessTokenExpiredException extends Exception
{
	public function __construct()
	{
		parent::__construct("The token is expired.");
	}
}