<?php

namespace App;

use App\Shift\ShiftFactory;
use App\Shift\Shifts;

class DataRepository {

	private const string FILE = 'dataset.json';

	public function __construct(
		private readonly ShiftFactory $shiftFactory = new ShiftFactory(),
	)
	{
	}

	public function getShifts(): Shifts
	{
		$shifts = new Shifts();

		$file = __dir__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .self::FILE;
		$data = file_get_contents($file);

		$json = json_decode($data, true);

		foreach ($json as $jsonShift) {
			$shift = $this->shiftFactory->create($jsonShift);
			$shifts->addShift($shift);
		}
		return $shifts;
	}
}
