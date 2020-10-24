<?php

interface Animal
{
	public function sayHello();
}

class Cat implements Animal
{
	public function sayHello()
	{
		return 'Meaow';
	}

	public function talk()
	{
		return $this->sayHello();
	}
}


$c = new Cat();
echo $c->talk();