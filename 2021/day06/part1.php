<?php
$string = file_get_contents('input.txt');
$array = explode(",", $string);

function getNumberOfItem($value, $nbRow = 80)
{
    $array[] = $value;
    for ($i = 0; $i < $nbRow; $i++) {
        foreach ($array as $key => $value) {
            if ($value === 0) {
                $array[$key] = 6;
                $array[] = 8;
            } else {
                $array[$key]--;
            }
        }
    }

    return count($array);
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
