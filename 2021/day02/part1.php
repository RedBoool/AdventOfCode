<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

$forward = $depth = 0;
foreach ($array as $line) {
    list($action, $unit) = explode(' ', $line);

    if ($action == 'forward') {
        $forward += $unit;
    } elseif ($action == 'up') {
        $depth -= $unit;
    } elseif ($action == 'down') {
        $depth += $unit;
    } else {
        print 'We have a problem';
    }
    //print $action.' - '.$unit.PHP_EOL;
}

print 'Exercice 1: '.PHP_EOL;
print 'Forward: '.$forward.PHP_EOL;
print 'Depth: '.$depth.PHP_EOL;
print 'Result: '.($forward * $depth).PHP_EOL;

