<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

$previous = null;
$higher = $lower = $equal = 0;
foreach ($array as $value) {
    if (empty($previous)) {
        $previous = $value;
        continue;
    }

    if ($value === $previous) {
        $equal++;
    } else if ($value > $previous) {
        $higher++;
    } else {
        $lower++;
    }

    $previous = $value;
}

print 'Exercice 1: '.PHP_EOL;
print 'Higher: '.$higher.PHP_EOL;
print 'Lower: '.$lower.PHP_EOL;
print 'Equal: '.$equal.PHP_EOL;
