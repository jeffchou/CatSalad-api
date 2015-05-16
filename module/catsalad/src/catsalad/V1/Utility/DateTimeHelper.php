<?php
namespace catsalad\V1\Utility;

class DateTimeHelper
{
	/**
	 * Converts current time for given timezone (considering DST)
	 *  to 14-digit UTC timestamp (YYYYMMDDHHMMSS)
	 *
	 * DateTime requires PHP >= 5.2
	 *
	 * @param string $str_server_timezone
	 * @param string $str_server_dateformat
	 * @return string
	 */
	public static function nowDateTime($str_server_timezone, $str_server_dateformat)
	{
		date_default_timezone_set($str_server_timezone);
		$date = new \DateTime('now');
		$str_server_now = $date->format($str_server_dateformat);

		return $str_server_now;
	}

	public static function nowDateTimeUTC($str_server_dateformat)
	{
		date_default_timezone_set('Asia/Taipei');
		$date = new \DateTime('now');
		$str_server_now = $date->format($str_server_dateformat);

		return $str_server_now;
	}

	public static function dateTimeUTC($str_server_dateformat, 
										$year, $month, $day, 
										$hour, $minute, $second)
	{
		date_default_timezone_set('Asia/Taipei');
		$date = new \DateTime('now');
		$date->setDate($year, $month, $day);
		$date->setTime($hour, $minute, $second);
		$str_server_now = $date->format($str_server_dateformat);

		return $str_server_now;
	}

	public static function nowWithTimeUTC($str_server_dateformat, 
										$hour, $minute, $second)
	{
		date_default_timezone_set('Asia/Taipei');
		$date = new \DateTime('now');
		$date->setTime($hour, $minute, $second);
		$str_server_now = $date->format($str_server_dateformat);

		return $str_server_now;
	}
}