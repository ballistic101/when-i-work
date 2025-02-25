<?php

namespace App\Tests;

use App\Week;
use PHPUnit\Framework\TestCase;

class WeekTest extends TestCase {

	public function testWeek(): void
	{
		$week = new Week(
			1,
			'start-of-week',
			0.5,
			2.4,
			[123, 456],
		);

		$expectedArr = [
			'EmployeeID' => 1,
			'StartOfWeek' => 'start-of-week',
			'RegularHours' => 0.5,
			'OvertimeHours' => 2.4,
			'InvalidShifts' => [123, 456],
		];

		$this->assertEquals($expectedArr, $week->toArray());
	}
}
