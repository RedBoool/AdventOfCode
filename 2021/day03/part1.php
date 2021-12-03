<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

$nb = [];
foreach ($array as $binary) {
    foreach (str_split($binary) as $key => $value) {
        if (empty($nb[$key][$value])) {
            $nb[$key][$value] = 1;
        } else {
            $nb[$key][$value]++;
        }
    }
}

$gamma = $epsilon = '';
foreach ($nb as $item) {
    if ($item[0] > $item[1]) {
        $gamma .= '0';
        $epsilon .= '1';
    } else {
        $gamma .= '1';
        $epsilon .= '0';
    }
}

$gamma = bindec($gamma);
$epsilon = bindec($epsilon);

print 'Exercice 1: '.PHP_EOL;
print 'Gamma: '.$gamma.PHP_EOL;
print 'Epsilon: '.$epsilon.PHP_EOL;
print 'Result: '.($gamma * $epsilon).PHP_EOL;
