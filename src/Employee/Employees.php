<?php

namespace App\Employee;

use App\Shift\Shift;
use App\Shift\Shifts;

class Employees {

	private array $employees = [];

	public function __construct(Shifts $shifts)
	{
		foreach ($shifts->getShifts() as $shift) {
			$this->addShift($shift);
		}
	}

	/**
	 * Given a shift, add it to the employee array.
	 */
	private function addShift(Shift $shift): void
	{
		$employeeId = $shift->employeeId;

		if (false === array_key_exists($employeeId, $this->employees)) {
			$this->employees[$employeeId] = new Employee($employeeId);
		}
		$this->employees[$employeeId]->addShift($shift);
	}

	public function getEmployees(): array
	{
		return $this->employees;
	}
}
