<?php

namespace App;

use App\Employee\Employee;
use App\Employee\Employees;
use App\Shift\Shift;
use App\Shift\Shifts;

class Filter {

	public function filterShifts(array $shifts): array
	{
		$illegalShifts = [];
		$legalShifts = [];

		foreach ($shifts as $shift) {
			$overlappingShifts = $this->overlappingShifts($shift, $shifts);
			if (count($overlappingShifts) > 0) {
				foreach ($overlappingShifts as $overlappingShift) {
					// Don't add duplications to the illegal list...
					if (false === in_array($overlappingShift->shiftId, $illegalShifts)) {
						$illegalShifts[] = $overlappingShift->shiftId;
					}
				}
			}
			else {
				$legalShifts[] = $shift;
			}
		}

		return [$illegalShifts, $legalShifts];
	}

	private function overlappingShifts(Shift $toCheck, array $shifts): array
	{
		$overlapping = [];
		foreach ($shifts as $shift) {

			if ($shift === $toCheck) {
				// Do not compare itself...
				continue;
			}

			if ($toCheck->startTime >= $shift->startTime && $toCheck->startTime <= $shift->endTime) {
				if (false === $this->isConsecutive($toCheck, $shift)) {
					$overlapping[] = $shift;
					$overlapping[] = $toCheck;
				}
			}

			if ($toCheck->endTime <= $shift->endTime && $toCheck->endTime >= $shift->startTime) {
				if (false === $this->isConsecutive($toCheck, $shift)) {
					$overlapping[] = $shift;
					$overlapping[] = $toCheck;
				}
			}
		}
		return $overlapping;
	}

	/**
	 *  If only the start or end of Shift has the same timestamp
	 *  then they are consecutive.
	 */
	private function isConsecutive(Shift $one, Shift $two): bool
	{
		if ($one->startTime == $two->endTime) {
			if ($one->endTime != $two->startTime) {
				return true;
			}
			return false;
		}

		// At this point the start time of the first Shift cannot match
		// the end time of the second Shift.
	
		if ($one->endTime == $two->startTime) {
			return true;
		}

		return false;
	}
}
