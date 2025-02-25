<?php

namespace App\Employee;

use App\Shift\Shifts;

class EmployeesFactory {

	public function create(Shifts $shift): Employees
	{
		return new Employees($shift);
	}
}
