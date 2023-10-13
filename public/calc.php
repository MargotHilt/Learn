<?php
/*
$value1 =  null;
$value2 = null;

function mult(float|int|null $value1 = 5, float|int|null $value2 = 100) : float|int
{

    return $value1 * $value2;
}

echo mult($value1 ?? 100, $value2 === null ? 2 : $value2); */

function calculate($num1, $num2, $operator) : float
{
    return match ($operator) {
        'add' => $num1 + $num2,
        'sub' => $num1 - $num2,
        'mult' => $num1 * $num2,
        'div' => $num1 / $num2,
        default => 'unknown value',
    };

}

require 'calc.html'; ?>
<div class="result">
    <h1>
    <?php echo calculate((float) $_REQUEST["num1"], (float) $_REQUEST["num2"], $_REQUEST["operator"]);
    ?>
    </h1>
</div>



