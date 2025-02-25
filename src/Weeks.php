<?php

namespace App;

class Weeks {

	private array $weeks = [];

	public function addWeek(
		int $employeeId,
		string $startOfWeek,
		float $regularHours,
		float $overtimeHours,
		array $illegalShifts,
	): void
	{
		$this->weeks[] = new Week(
			$employeeId,
			$startOfWeek,
			$regularHours,
			$overtimeHours,
			$illegalShifts,
		);
	}

	public function toArray(): array
	{
		$output = [];
		foreach ($this->weeks as $week) {
			$output[] = $week->toArray();
		}
		return $output;
	}
}
