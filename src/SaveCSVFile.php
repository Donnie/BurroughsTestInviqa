<?php

namespace Inviqa;

class SaveCSVFile implements SaveData
{
	public $data;

	public function set($data)
	{
		$this->data = $data;

		return true;
	}

	public function export($filename)
	{		
		$file = new \SplFileObject($filename, 'w');

		foreach ($this->data as $rows) {
		    $file->fputcsv($rows);
		}

		return true;
	}

}
