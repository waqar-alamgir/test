<?php

// 

class Factory{
    public function build()
    {
        $classc = $this->buildC();
        $classb = $this->buildB();
        return $this->buildA($classb, $classc);

    }

    public function buildA($classb, $classc)
    {
        return new ClassA($classb, $classc);
    }

    public function buildB()
    {
        return new ClassB;
    }

    public function buildC()
    {
        return new ClassC;
    }
}
