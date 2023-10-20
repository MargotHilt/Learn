<?php

namespace Simovative\Learn\Math;

class Multiply implements MathInterface
{
    public function calculate(float $num1, float $num2) : float
    {
        return $num1 * $num2;
    }
}
