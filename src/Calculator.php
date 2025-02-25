<?php

namespace App;

use App\Employee\Employee;
use App\Employee\Employees;
use App\Shift\Shift;
use App\Shift\Shifts;

class Calculator {

	public function __construct(
		private Filter $filter = new Filter(),
	)
	{
	}

	public function getEmployeeWeeks(Employees $employees): Weeks
	{
		$weeks = new Weeks();
		foreach ($employees->getEmployees() as $employee) {
			foreach ($employee->getWeeks() as $startOfWeek => $shifts) {
				[$illegalShifts, $legalShifts] = $this->filter->filterShifts($shifts);
				$totalHours = 0;
				foreach ($legalShifts as $shift) {
					$interval = $shift->startTime->diff($shift->endTime);
					$hours = $interval->d * 24;
					$hours += $interval->h;
					$hours += $interval->i / 60.0;
					$totalHours += $hours;
				}
				$overTime = 0;
				if ($totalHours > 40) {
					$overTime = $totalHours - 40;
					$totalHours -= $overTime;
				}
				$weeks->addWeek(
					$employee->id,
					$startOfWeek,
					$totalHours,
					$overTime,
					$illegalShifts,
				);
			}
		}
		return $weeks;
	}
}
