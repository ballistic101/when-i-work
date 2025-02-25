<?php

namespace App;

use App\Calculator;
use App\DataRepository;
use App\Employee\Employees;
use App\Employee\EmployeesFactory;

class App {

	public function __construct(
		private DataRepository $repo = new DataRepository(),
		private EmployeesFactory $employeesFactory = new EmployeesFactory(),
		private Calculator $calculator = new Calculator(),
		private Outputter $outputter = new Outputter(),
	)
	{
	}

	public function run(): void
	{
		// Get the Shift data from the repository
		$shifts = $this->repo->getShifts();

		// Use it to work out the Employee information
		$employees = $this->employeesFactory->create($shifts);

		// Perform the necessary calculations
		$employeeWeeks = $this->calculator->getEmployeeWeeks($employees);

		// Convert that information to JSON
		$arr = $employeeWeeks->toArray();
		$json = json_encode($arr);

		// Print it to stdout
		$this->outputter->writeln($json);
	}
}
