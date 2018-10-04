<?php

namespace Inviqa;

class DateUtility
{
	static public function getNext12Months()
	{
		$months = [];

		for ($i=1; $i < 13; $i++) { 
			$months[] = date('F Y', strtotime('today + '.$i.' month'));
		}

		return $months;
	}

	static public function getLastWorkingDay($month)
	{
		## calculate last working day
		$lastWDay = date('D, F j, Y', strtotime('last day of '.$month));

		## if last day is Sat or Sun then get last Friday
		if ((strpos($lastWDay, 'Sat') !== false) || (strpos($lastWDay, 'Sun') !== false)){
			$lastWDay = date('D, F j, Y', strtotime('last Friday of '.$month));
		}

		return $lastWDay;
	}

	static public function getMiddleWednesday($month)
	{
		## calculate the bonus day
		$midWDay = date('D, F j, Y', strtotime('15 '.$month.' + 1 month'));

		## if bonus day is Sat or Sun then get last Friday
		if ((strpos($midWDay, 'Sat') !== false) || (strpos($midWDay, 'Sun') !== false)){
			$midWDay = date('D, F j, Y', strtotime($midWDay.' next Wednesday'));
		}

		return $midWDay;
	}
}
