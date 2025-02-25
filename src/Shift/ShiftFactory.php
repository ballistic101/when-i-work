<?php

namespace App\Shift;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Exception;

class ShiftFactory {

	public function create(array $data): Shift
   	{
		$shiftId = $data['ShiftID'];
		$employeeId = $data['EmployeeID'];

		// Take the time strings (which contain a timezone) and
		// convert them to DateTimeImmutable objects
		// in the Central timezone.
		// This is because all the calculations use that timezone.
		$start = new DateTime($data['StartTime']);
		$start->setTimeZone(new DateTimeZone('America/Chicago'));
		$startImm = DateTimeImmutable::createFromMutable($start);

		$end = new DateTime($data['EndTime']);
		$end->setTimeZone(new DateTimeZone('America/Chicago'));
		$endImm = DateTimeImmutable::createFromMutable($end);

		if ($startImm > $endImm) {
			throw new Exception('Start time is later than End time!');
		}

		return new Shift($shiftId, $employeeId, $startImm, $endImm);
	}
}
