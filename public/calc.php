<?php
/*
$value1 =  null;
$value2 = null;

function mult(float|int|null $value1 = 5, float|int|null $value2 = 100) : float|int
{

    return $value1 * $value2;
}

echo mult($value1 ?? 100, $value2 === null ? 2 : $value2); */

require '../src/Calculator.php';

require 'calc.html';

$num1 = $_REQUEST['num1'] ?? 0;
$num2 = $_REQUEST['num2'] ?? 0;
$operator = $_REQUEST['operator']  ?? 'add';

if (!is_numeric($num1)) {
    $num1 = 0;
}

if (!is_numeric($num2)) {
    $num2 = 0;
}

$calculator = new Calculator($num1, $num2, $operator);
$calculator->calculate();
$result = $calculator->getResult();

?>
<div class="result">
    <h1>
    <?php
        echo $result;
    ?>
    </h1>
</div>



