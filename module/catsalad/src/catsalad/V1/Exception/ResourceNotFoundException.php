<?php
namespace catsalad\V1\Exception;

use Exception;

class ResourceNotFoundException extends Exception
{
	public function __construct($id)
	{
		parent::__construct(sprintf("The resource (%s) is not found.", $id));
	}
}