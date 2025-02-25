<?php

namespace App\Tests;

use App\Week;
use App\Weeks;
use PHPUnit\Framework\TestCase;

class WeeksTest extends TestCase {

	public function testWeeks(): void
	{
		$weeks = new Weeks();

		// Initially there is nothing in there.
		$this->assertEquals([], $weeks->toArray());

		$weeks->addWeek(
			1,
			'start-of-week',
			0.5,
			2.4,
			[123, 456],
		);

		$arr = $weeks->toArray();

		$this->assertIsArray($arr);
		$this->assertCount(1, $arr);

		$expectedArr = [
			[
				'EmployeeID' => 1,
				'StartOfWeek' => 'start-of-week',
				'RegularHours' => 0.5,
				'OvertimeHours' => 2.4,
				'InvalidShifts' => [123, 456],
			]
		];

		$this->assertEquals($expectedArr, $arr);
	}
}
