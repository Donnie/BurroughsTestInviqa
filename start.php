<?php

date_default_timezone_set("Asia/Calcutta");
set_time_limit(0);

require_once 'vendor/autoload.php';

/**
 * Get Args from Command Line
 */

if (isset($argv[1])) {
	$fileName = $argv[1];
} else {
	$fileName = 'salary-days';
}

# solve for .csv extension
if (strpos($fileName, '.csv') === false){
	$fileName .= '.csv';
}

# create folder
if (!file_exists(__DIR__.'/output')) {
    mkdir(__DIR__.'/output', 0777, true);
}

# create empty file
$csvFile = fopen(__DIR__ .'/output/'.$fileName, 'w');


/**
 * Work on the problem
 */

# Get upcoming 12 months
## Get next 12 months
$months = [];
for ($i=1; $i < 13; $i++) { 
	$months[] = date('F Y', strtotime('today + '.$i.' month'));
}

# Enter month loop
foreach ($months as $month) {

	## calculate last working day
	$salaryDay = date('D, F j, Y', strtotime('last day of '.$month));

	## if last day is Sat or Sun then get last Friday
	if ((strpos($salaryDay, 'Sat') !== false) || (strpos($salaryDay, 'Sun') !== false)){
		$salaryDay = date('D, F j, Y', strtotime('last Friday of '.$month));
	}

	## calculate the bonus day
	$bonusDay = date('D, F j, Y', strtotime('15 '.$month.' + 1 month'));

	## if bonus day is Sat or Sun then get last Friday
	if ((strpos($bonusDay, 'Sat') !== false) || (strpos($bonusDay, 'Sun') !== false)){
		$bonusDay = date('D, F j, Y', strtotime($bonusDay.' next Wednesday'));
	}

	$dates[] = [
		$month,
		$salaryDay,
		$bonusDay
	];
}

/**
 * Instantiate CSV file as object using library
 */

$csvFile = new Keboola\Csv\CsvWriter(__DIR__ . '/output/'.$fileName);
$rows = [
	[
		'month', 'salary date', 'bonus date'
	]
];

foreach ($dates as $dateRow) {
	$rows[] = $dateRow;
}

## write to file
foreach ($rows as $row) {
	$csvFile->writeRow($row);
}

/**
 * Das ist alles!
 */
