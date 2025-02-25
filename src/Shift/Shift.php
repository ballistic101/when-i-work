<?php

namespace App\Shift;

use DateTimeImmutable;

class Shift {

	public function __construct(
		public int $shiftId,
		public int $employeeId,
		public DateTimeImmutable $startTime,
		public DateTimeImmutable $endTime,
	)
	{
	}
}
