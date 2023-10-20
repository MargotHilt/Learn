<?php

namespace Simovative\Learn;

interface CalculatorInterface
{
    public function getResult() : float|int;

    public function calculate() : void;
}