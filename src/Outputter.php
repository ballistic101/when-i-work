<?php

namespace App;

class Outputter {

	public function writeln(string $str): void
	{
		echo $str . "\n";
	}
}
