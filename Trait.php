<?php

trait Wheel {
	private $color;
	public function rotate()
	{
		$this->color = 'Red';
	}
}

class Car {
	use Wheel;

	public function view()
	{
		echo $this->color;
	}
}


$c = new Car();
$c->rotate();
$c->view();