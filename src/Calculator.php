<?php
 class Calculator
 {
     private const MATH_PlUS = 'add';
     private const MATH_SUB = 'sub';
     private const MATH_MULT = 'mult';
     private const MATH_DIV = 'div';

     private float|int $result = 0;


     public function __construct(
         private float|int $num1,
         private float|int $num2,
         private string $operator
     ) {
     }

     public function getResult() : float|int
     {
         return $this->result;
     }

     public function add() : float|int
     {
         return $this->num1 + $this->num2;
     }

     public function substract() : float|int
     {
         return $this->num1 - $this->num2;
     }

     public function multiply() : float|int
     {
         return $this->num1 * $this->num2;
     }

     public function divide() : float|int
     {
         return $this->num1 / $this->num2;
     }

     public function calculate() : void
     {
         $this->result = match ($this->operator) {
             Calculator::MATH_PlUS => $this->add(),
             Calculator::MATH_SUB => $this->substract(),
             Calculator::MATH_MULT => $this->multiply(),
             Calculator::MATH_DIV => $this->divide(),
             default => 0,
         };
     }
 }