<?php

namespace Inviqa;

class DateUtility
{
	public static $weekend = ['Sat', 'Sun'];

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public static function getNext12Months()
	{
		$months = [];

		for ($i = 1; $i < 13; $i++) { 
			$months[] = date('F Y', strtotime('today + '.$i.' month'));
		}

		return $months;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $month
	 * @return void
	 */
	public static function getLastWorkingDay($month)
	{
		## calculate last working day
		$lastWDay = date('D, F j, Y', strtotime('last day of '.$month));

		## if last day is Sat or Sun then get last Friday
		if (self::match(self::$weekend, $lastWDay)){
			$lastWDay = date('D, F j, Y', strtotime('last Friday of '.$month));
		}

		return $lastWDay;
	}

	public static function getMiddleWednesday($month)
	{
		## calculate the bonus day
		$midWDay = date('D, F j, Y', strtotime('15 '.$month.' + 1 month'));

		## if bonus day is Sat or Sun then get last Friday
		if (self::match(self::$weekend, $midWDay)){
			$midWDay = date('D, F j, Y', strtotime($midWDay.' next Wednesday'));
		}

		return $midWDay;
	}

	public static function match(Array $words, $string)
	{
	    foreach($words as $word){
	        if (strpos($string, $word) !== false) {
	            return true;
	        }
	    }
	    return false;
	}
}
