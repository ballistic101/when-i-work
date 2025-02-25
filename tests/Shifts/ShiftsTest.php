<?php

namespace App\Tests\Shift;

use App\Shift\Shift;
use App\Shift\Shifts;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ShiftsTest extends TestCase {

	public function testShifts(): void
	{
		$shifts = new Shifts();

		// There are no shifts added yet.
		$this->assertEquals([], $shifts->getShifts());

		$shift = new Shift(
			17, // shiftId
			22, // employeeId
			new DateTimeImmutable('now'), // startTime
			new DateTimeImmutable('now'), // endTime
		);

		$shifts->addShift($shift);

		$arr = $shifts->getShifts();

		$this->assertIsArray($arr);
		$this->assertCount(1, $arr);
		$this->assertInstanceOf(Shift::class, $arr[17]);
		$this->assertEquals($shift, $arr[17]);
	}
}
