<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

$forward = $depth = $aim = 0;
foreach ($array as $line) {
    list($action, $unit) = explode(' ', $line);

    if ($action == 'forward') {
        $forward += $unit;
        $depth += $aim * $unit;

        print 'Forward: '.$forward.PHP_EOL;
        print 'Depth: '.$depth.PHP_EOL;
        print PHP_EOL;
    } elseif ($action == 'up') {
        $aim -= $unit;
    } elseif ($action == 'down') {
        $aim += $unit;
    } else {
        print 'We have a problem';
    }
    //print $action.' - '.$unit.PHP_EOL;
}

print 'Exercice 1: '.PHP_EOL;
print 'Forward: '.$forward.PHP_EOL;
print 'Depth: '.$depth.PHP_EOL;
print 'Result: '.($forward * $depth).PHP_EOL;

