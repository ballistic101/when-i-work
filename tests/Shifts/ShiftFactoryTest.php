<?php

namespace App\Tests\Shift;

use App\Shift\ShiftFactory;
use App\Shift\Shift;
use DateTimeImmutable;
use Exception;
use PHPUnit\Framework\TestCase;

class ShiftFactoryTest extends TestCase {

	public function testShiftFactory(): void
	{
		$factory = new ShiftFactory();

		$data = [
			'ShiftID' => 17,
			'EmployeeID' => 23,
			'StartTime' => '2025-02-24 10:00:00',
			'EndTime' => '2025-02-24 12:00:00',
			'ExtraData' => 'will-be-ignored',
		];

		$shift = $factory->create($data);

		$this->assertInstanceOf(Shift::class, $shift);
	}

	public function testShiftFactory_badDates(): void
	{
		$factory = new ShiftFactory();

		$data = [
			'ShiftID' => 17,
			'EmployeeID' => 23,
			'StartTime' => '2025-02-24 20:00:00', // Note this is later
			'EndTime' => '2025-02-24 12:00:00',
		];

		$this->expectException(Exception::class);

		$factory->create($data);
	}

	// Missing params or bad types (like ShiftID being a string)
	// will throw compiler exceptions because they are type hinted.
}
