<?php

namespace App\Tests\Employee;

use App\Employee\Employee;
use App\Employee\Employees;
use App\Shift\Shift;
use App\Shift\Shifts;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class EmployeesTest extends TestCase {

	public function testEmployees(): void
	{
		$shifts = new Shifts();

		$shift1 = new Shift(
			17, // shiftId
			22, // employeeId
			new DateTimeImmutable('2025-02-24 10:00:00', new DateTimeZone('America/Chicago')), // startTime
			new DateTimeImmutable('2025-02-24 12:00:00', new DateTimeZone('America/Chicago')), // endTime
		);
		$shifts->addShift($shift1);

		$shift2 = new Shift(
			18, // shiftId
			22, // employeeId
			new DateTimeImmutable('2025-03-01 23:00:00', new DateTimeZone('America/Chicago')), // startTime
			new DateTimeImmutable('2025-03-02 02:00:00', new DateTimeZone('America/Chicago')), // endTime - next week
		);
		$shifts->addShift($shift2);


		$employees = new Employees($shifts);

		$arr = $employees->getEmployees();
		$this->assertIsArray($arr);
		$this->assertCount(1, $arr);
		$this->assertInstanceOf(Employee::class, $arr[22]);
	}
}
