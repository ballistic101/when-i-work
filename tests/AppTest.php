<?php

namespace App\Tests;

use App\App;
use App\Calculator;
use App\DataRepository;
use App\Employee\Employees;
use App\Employee\EmployeesFactory;
use App\Outputter;
use App\Shift\Shifts;
use App\Weeks;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {

	public function testApp(): void
	{
		$repo = $this->createMock(DataRepository::class);
		$employeesFactory = $this->createMock(EmployeesFactory::class);
		$calculator = $this->createMock(Calculator::class);
		$outputter = $this->createMock(Outputter::class);

		$app = new App($repo, $employeesFactory, $calculator, $outputter);

		$shifts = $this->createMock(Shifts::class);

		$repo->expects($this->once())
			->method('getShifts')
			->willReturn($shifts);

		$employees = $this->createMock(Employees::class);

		$employeesFactory->expects($this->once())
			->method('create')
			->with($shifts)
			->willReturn($employees);

		$weeks = $this->createMock(Weeks::class);

		$calculator->expects($this->once())
			->method('getEmployeeWeeks')
			->with($employees)
			->willReturn($weeks);

		$weeks->expects($this->once())
			->method('toArray')
			->willReturn(['a' => 'b']);

		$outputter->expects($this->once())
			->method('writeln')
			->with('{"a":"b"}');

		$app->run();
	}
}
