<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function init($array):array
{
    $i = 0;
    $input = '';
    $pairList = [];
    foreach ($array as $value) {
        if ($i === 0) {
            $input = $value;
        } elseif ($i > 1) {
            $pair = explode(' -> ', $value);
            $pairList[$pair[0]] = $pair[1];
        }
        $i++;
    }

    return [$input, $pairList];
}

function insert(string $input, array $pairList): string
{
    $output = $input[0];
    for ($i = 1; $i < strlen($input); $i++) {
        $output .= $pairList[$input[$i - 1].$input[$i]];
        $output .= $input[$i];
    }

    return $output;
}

function getNb(string $str): array
{
    $nb = [];
    for ($i = 1; $i < strlen($str); $i++) {
        if (empty($nb[$str[$i]])) {
            $nb[$str[$i]] = 1;
        } else {
            $nb[$str[$i]]++;
        }
    }

    return $nb;
}

list($input, $pairList) = init($array);

for ($i = 0; $i < 10; $i++) {
    $input = insert($input, $pairList);
}

$nbEachChar = getNb($input);
$result = max($nbEachChar) - min($nbEachChar);
print 'Result: '.$result.PHP_EOL;
