<?php

namespace App\Employee;

use App\Shift\Shift;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;

class Employee {

	/** @var Shift[] $weeks */
	private array $weeks = [];

	public function __construct(
		public int $id,
	)
	{
	}

	/**
	 * When adding a shift, add it for the week.
	 * It is possible for a shift to span weeks. In that case
	 * it needs to be broken up and two get added.
	 */
	public function addShift(Shift $shift): void
	{
		$shifts = $this->breakUpIntoWeeks($shift);

		foreach ($shifts as $oneShift) {
			$startOfWeek = $this->calcStartOfWeek($oneShift);

			if (false === array_key_exists($startOfWeek, $this->weeks)) {
				$this->weeks[$startOfWeek] = [];
			}
			$this->weeks[$startOfWeek][] = $oneShift;
		}
	}

	private function breakUpIntoWeeks(Shift $shift): array
	{
		$shifts = [];
		$startOfWeek = $this->calcStartOfWeek($shift);

		$shiftStart = $shift->startTime;
		$nextWeek = new DateTime($startOfWeek, new DateTimeZone('America/Chicago'));
		$nextWeek->setTime(0, 0);
		$nextWeek->modify('+1 week');
		while ($shift->endTime > $nextWeek) {
			$newEnd = clone $nextWeek;
			$newEnd->modify('-1 seconds');
			$shifts[] = new Shift(
				$shift->shiftId,
				$shift->employeeId,
				new DateTimeImmutable($shiftStart->format('Y-m-d H:i:s'), new DateTimeZone('America/Chicago')),
				new DateTimeImmutable($newEnd->format('Y-m-d H:i:s'), new DateTimeZone('America/Chicago')),
			);
			$shiftStart = clone $nextWeek;
			$nextWeek->modify('+1 week');
		}
		// There is always the last shift to add
		// In most cases this will be the entire shift.
		$shifts[] = new Shift(
			$shift->shiftId,
			$shift->employeeId,
			new DateTimeImmutable($shiftStart->format('Y-m-d H:i:s'), new DateTimeZone('America/Chicago')),
			new DateTimeImmutable($shift->endTime->format('Y-m-d H:i:s'), new DateTimeZone('America/Chicago')),
		);
		return $shifts;
	}

	private function calcStartOfWeek($shift): string
	{
		$start = DateTime::createFromImmutable($shift->startTime);
		// Find the beginning of the week for that time.
		// Note: ISO 8601 cannot be used because a week starts on Monday
		$start->modify('next Sunday');
		$start->modify('-7 days');
		return $start->format('Y-m-d');
	}

	public function getWeeks(): array
	{
		return $this->weeks;
	}

}
