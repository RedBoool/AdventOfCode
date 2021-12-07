<?php
$string = file_get_contents('input.txt');
$array = explode(",", $string);

$min = min($array);
$max = max($array);

print 'Min: '.$min.PHP_EOL;
print 'Max: '.$max.PHP_EOL;

function getConsumption(int $value) {
    $consumption = 0;
    for ($i = 1; $i <= $value; $i++) {
        $consumption += $i;
    }

    return $consumption;
}

$minResult = null;
$position = null;
for ($i = $min; $i <= $max; $i++) {
    $currentResult = 0;
    foreach ($array as $value) {
        if ($value > $i) {
            $currentResult += getConsumption($value - $i);
        } elseif ($value < $i) {
            $currentResult += getConsumption($i - $value);
        }
    }

    if ($minResult === null) {
        $minResult = $currentResult;
        $position = $i;
    } elseif ($currentResult < $minResult) {
        $minResult = $currentResult;
        $position = $i;
    }
}

print 'Position: '.$position.PHP_EOL;
print 'Minimum fuel (Result): '.$minResult.PHP_EOL;

