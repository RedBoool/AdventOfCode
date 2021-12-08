<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

$nbResult = 0;
foreach ($array as $line) {
    $exploded = explode('|', $line);
    $values = trim($exploded[1]);

    $arrayValue = explode(' ', $values);
    foreach ($arrayValue as $value) {
        if (in_array(strlen($value), [2,3,4,7])) {
            $nbResult++;
        }
    }
}

print 'Result: '.$nbResult.PHP_EOL;
