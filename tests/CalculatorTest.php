<?php

namespace App\Tests;

use App\Calculator;
use App\Filter;
use App\Employee\Employee;
use App\Employee\Employees;
use App\Shift\Shift;
use App\Shift\Shifts;
use App\Weeks;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase {

	public function testCalculator(): void
	{
		$filter = $this->createMock(Filter::class);

		$calc = new Calculator($filter);

		$employees = $this->createMock(Employees::class);

		$shift = new Shift(
			17, // shiftId
			22, // employeeId
			new DateTimeImmutable('2025-02-24 10:00:00', new DateTimeZone('America/Chicago')), // startTime
			new DateTimeImmutable('2025-02-24 12:00:00', new DateTimeZone('America/Chicago')), // endTime
		);

		$employee = new Employee(22);
		$employee->addShift($shift);

		$employees->expects($this->once())
			->method('getEmployees')
			->willReturn([$employee]);

		$filter->expects($this->once())
			->method('filterShifts')
			->with([$shift])
			->willReturn([ [], [$shift] ]);

		$weeks = $calc->getEmployeeWeeks($employees);

		$this->assertInstanceOf(Weeks::class, $weeks);

		$arr = $weeks->toArray();
		$this->assertIsArray($arr);

		$expectedArr = [
			[
				'EmployeeID' => 22,
				'StartOfWeek' => '2025-02-23',
				'RegularHours' => 2.00,
				'OvertimeHours' => 0.00,
				'InvalidShifts' => [],
			],
		];
		$this->assertEquals($expectedArr, $arr);
	}
}
