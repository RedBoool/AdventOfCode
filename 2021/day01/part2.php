<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

$previous1 = $previous2 = $previous3 = null;
$higher = $lower = $equal = 0;
foreach ($array as $value) {
    if (empty($previous1)) {
        $previous1 = $value;
        continue;
    } elseif (empty($previous2)) {
        $previous2 = $previous1;
        $previous1 = $value;
        continue;
    } elseif (empty($previous3)) {
        $previous3 = $previous2;
        $previous2 = $previous1;
        $previous1 = $value;

        $previousSum = $previous1 + $previous2 + $previous3;
        continue;
    }

    $sum = $value + $previous1 + $previous2;

    if ($sum === $previousSum) {
        $equal++;
    } else if ($sum > $previousSum) {
        $higher++;
    } else {
        $lower++;
    }

    $previous3 = $previous2;
    $previous2 = $previous1;
    $previous1 = $value;
    $previousSum = $sum;
}

print 'Exercice 2: '.PHP_EOL;
print 'Higher: '.$higher.PHP_EOL;
print 'Lower: '.$lower.PHP_EOL;
print 'Equal: '.$equal.PHP_EOL;
