<?php
$string = file_get_contents('input.txt');
$array = explode(",", $string);

$min = min($array);
$max = max($array);

print 'Min: '.$min.PHP_EOL;
print 'Max: '.$max.PHP_EOL;

$minResult = null;
$position = null;
for ($i = $min; $i <= $max; $i++) {
    $currentResult = 0;
    foreach ($array as $value) {
        if ($value > $i) {
            $currentResult += $value - $i;
        } elseif ($value < $i) {
            $currentResult += $i - $value;
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

