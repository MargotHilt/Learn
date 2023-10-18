<?php
/*
$value1 =  null;
$value2 = null;

function mult(float|int|null $value1 = 5, float|int|null $value2 = 100) : float|int
{

    return $value1 * $value2;
}

echo mult($value1 ?? 100, $value2 === null ? 2 : $value2); */

require '../src/MathInterface.php';
require '../src/Add.php';
require '../src/Substract.php';
require '../src/Multiply.php';
require '../src/Divide.php';
require '../src/Math.php';
require '../src/CalculatorInterface.php';
require '../src/Calculator.php';


/*try {
    $exception = new Exception('Error');
    throw $exception;
} catch (Exception $exception) {
    echo $exception->getMessage();
    exit;
}*/

$stringnum1 = str_replace(',', '.', ($_REQUEST['num1'] ?? 0));
$stringnum2 = str_replace(',', '.', ($_REQUEST['num2'] ?? 0));

$num1 = (float) $stringnum1;
$num2 = (float) $stringnum2;
$operator = $_REQUEST['operator']  ?? 'add';

if (!is_numeric($num1)) {
    $num1 = 0.0;
}

if (!is_numeric($num2)) {
    $num2 = 0.0;
}

$calculator = new Calculator($num1, $num2, $operator);
$calculator->calculate();
$result = $calculator->getResult();

require 'calcTemplate.php';

?>




