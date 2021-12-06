<?php
$string = file_get_contents('input.txt');
$array = explode(",", $string);

function getNumberOfItem($value, $nbRow = 256): int
{
    $array = array_fill(0, 9, 0);
    $array[$value] = 1;

    for ($i = 0; $i < $nbRow; $i++) {
        $baby = $array[0];

        for ($j = 0; $j < 8; $j++) {
            $array[$j] = $array[$j+1];
        }
        $array[6] += $baby; // Made a baby
        $array[8] = $baby; // Is a baby
    }

    $numberOfItem = 0;
    foreach ($array as $value) {
        $numberOfItem += $value;
    }

    return $numberOfItem;
}

$nb = 0;
$cache = [];
foreach ($array as $value) {
    if (empty($cache[$value])) {
        $cache[$value] = getNumberOfItem($value);
    }

    $nb += $cache[$value];
}

print 'Result: '.$nb.PHP_EOL;
