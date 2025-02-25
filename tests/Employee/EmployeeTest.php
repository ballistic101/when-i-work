<?php

namespace App\Tests\Employee;

use App\Employee\Employee;
use App\Shift\Shift;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase {

	public function testEmployee(): void
	{
		$employee = new Employee(22);

		$this->assertEquals(22, $employee->id);

		// There are no shifts added yet.
		$this->assertEquals([], $employee->getWeeks());

		// Add a shift
		$shift = new Shift(
			17, // shiftId
			22, // employeeId
			new DateTimeImmutable('2025-02-24 10:00:00', new DateTimeZone('America/Chicago')), // startTime
			new DateTimeImmutable('2025-02-24 12:00:00', new DateTimeZone('America/Chicago')), // endTime
		);

		$employee->addShift($shift);

		$arr = $employee->getWeeks();

		$this->assertIsArray($arr);
		$this->assertCount(1, $arr);
		// There is a Shift added to the "first of the week"
		$this->assertIsArray($arr['2025-02-23']);
		$this->assertCount(1, $arr['2025-02-23']);
		$this->assertInstanceOf(Shift::class, $arr['2025-02-23'][0]);
		$this->assertEquals($shift, $arr['2025-02-23'][0]);

		// Add another shift
		$shift2 = new Shift(
			18, // shiftId
			22, // employeeId
			new DateTimeImmutable('2025-03-01 23:00:00', new DateTimeZone('America/Chicago')), // startTime
			new DateTimeImmutable('2025-03-02 02:00:00', new DateTimeZone('America/Chicago')), // endTime - next week
		);
		$employee->addShift($shift2);

		$arr2 = $employee->getWeeks();

		$this->assertIsArray($arr2);
		$this->assertCount(2, $arr2);
		// There is a Shift added to the "first of the week"
		$this->assertIsArray($arr2['2025-02-23']);
		$this->assertCount(2, $arr2['2025-02-23']);
		$this->assertInstanceOf(Shift::class, $arr2['2025-02-23'][0]);
		$this->assertEquals($shift, $arr2['2025-02-23'][0]);
		// The second Shift has been cut in half
		$startTime = $arr2['2025-02-23'][1]->startTime;
        $this->assertEquals('2025-03-01 11:00:00', $startTime->format('Y-m-d h:i:s'));
		$endTime = $arr2['2025-02-23'][1]->endTime;
        $this->assertEquals('2025-03-01 11:59:59', $endTime->format('Y-m-d h:i:s'));

		$this->assertInstanceOf(Shift::class, $arr2['2025-03-02'][0]);
		$startTime2 = $arr2['2025-03-02'][0]->startTime;
		$endTime2 = $arr2['2025-03-02'][0]->endTime;
		// Note capital H is used in the format, otherwise it would be 12am
		$this->assertEquals('2025-03-02 00:00:00', $startTime2->format('Y-m-d H:i:s'));
		$this->assertEquals('2025-03-02 02:00:00', $endTime2->format('Y-m-d h:i:s'));
	}
}
