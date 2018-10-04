<?php

namespace Inviqa;

class PayDays
{
	public $fileName = 'salary-days';
	public $directory = 'storage';
	public $message;
	protected $datesRow = [];
	
	function __construct($input)
	{
		if (isset($input[1])) {
			$this->fileName = $input[1];
		}
	}

	public function execute()
	{
		## Calculate Days and Export
		try {

			$this
				->getFilename()
				->calculate()
				->export();

			$this->message = "Success!\n";
			$this->message .= "Please find the output in $this->fileName";

		} catch (\Exception $e) {
			$this->message = "Failure!\n";
		}

		return $this->message;
	}

	protected function getFilename()
	{
		if (strpos($this->fileName, '.csv') === false){
			$this->fileName .= '.csv';
		}

		if (!file_exists(getcwd().'/'.$this->directory)) {
		    mkdir(getcwd().'/'.$this->directory, 0777, true);
		}

		$this->fileName = getcwd() .'/'.$this->directory."/".$this->fileName;

		fopen($this->fileName, 'w');

		return $this;
	}

	protected function calculate()
	{

		// Get months first
		$months = DateUtility::getNext12Months();

		foreach ($months as $month) {
			$this->datesRow[] = [
				$month,
				DateUtility::getLastWorkingDay($month),
				DateUtility::getMiddleWednesday($month)
			];
		}

		return $this;
	}

	protected function export()
	{
		// Here you could swap out with
		// any class which has set() and export()
		// methods.

		$fileSaver = new SaveCSVFile();

		$this
			->formatCSV()
			->saveDataToFile($fileSaver);

		return $this;
	}

	protected function formatCSV()
	{
		$tableHead = [
			'month', 'salary date', 'bonus date'
		];

		array_unshift($this->datesRow, $tableHead);

		return $this;
	}

	protected function saveDataToFile(SaveData $fileSaver)
	{
		$fileSaver->set($this->datesRow);
		$fileSaver->export($this->fileName);

		return $this;
	}
}
