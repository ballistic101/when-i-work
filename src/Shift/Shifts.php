<?php

namespace App\Shift;

class Shifts {

	private array $shifts = [];

	public function addShift(Shift $shift): void
	{
		$this->shifts[$shift->shiftId] = $shift;
	}

	public function getShifts(): array
	{
		return $this->shifts;
	}
}
