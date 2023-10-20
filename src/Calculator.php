<?php

namespace Simovative\Learn;

 class Calculator extends MathResult implements CalculatorInterface
 {
     private MathInterface $add;
     private MathInterface $substract;
     private MathInterface $multiply;
     private MathInterface $divide;

     private const MATH_PlUS = 'add';
     private const MATH_SUB = 'sub';
     private const MATH_MULT = 'mult';
     private const MATH_DIV = 'div';

     public function __construct(
         private float $num1,
         private float $num2,
         private string $operator
     ) {
         $this->add = new Add();
         $this->substract = new Substract();
         $this->multiply = new Multiply();
         $this->divide = new Divide();
     }

     public function getResult() : float
     {
         return $this->result;
     }

     public function calculate() : void
     {
         $this->result = match ($this->operator) {
             Calculator::MATH_PlUS => $this->add->calculate($this->num1, $this->num2),
             Calculator::MATH_SUB => $this->substract->calculate($this->num1, $this->num2),
             Calculator::MATH_MULT => $this->multiply->calculate($this->num1, $this->num2),
             Calculator::MATH_DIV => $this->divide->calculate($this->num1, $this->num2),
             default => 0,
         };
     }
 }