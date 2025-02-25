<?php

namespace App;

class Week {

	public function __construct(
		public int $employeeId,
		public string $startOfWeek,
		public float $regularHours,
		public float $overtimeHours,
		public array $invalidShifts,
	)
	{
	}

	public function toArray(): array
	{
		return [
			'EmployeeID' => $this->employeeId,
			'StartOfWeek' => $this->startOfWeek,
			'RegularHours' => (float)sprintf("%.2f", $this->regularHours),
			'OvertimeHours' => (float)sprintf("%.2f", $this->overtimeHours),
			'InvalidShifts' => $this->invalidShifts,
		];
	}
}
