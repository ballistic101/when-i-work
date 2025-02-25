<?php

namespace App\Tests\Employee;

use App\Employee\Employees;
use App\Employee\EmployeesFactory;
use App\Shift\Shifts;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

class EmployeesFactoryTest extends TestCase {

	public function testEmployeesFactory(): void
	{
		$factory = new EmployeesFactory();

		$shifts = $this->createMock(Shifts::class);

		$shifts->expects($this->once())
			->method('getShifts')
			->willReturn([]);

		$employees = $factory->create($shifts);

		$this->assertInstanceOf(Employees::class, $employees);
	}
}
