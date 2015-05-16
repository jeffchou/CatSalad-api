<?php
namespace catsalad\V1\Utility;

use Rhumsaa\Uuid\Uuid;

class UuidHelper
{
	public static function uuid()
	{
		return Uuid::uuid4();
	}
}
