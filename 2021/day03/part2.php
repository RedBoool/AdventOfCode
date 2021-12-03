<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function getMaxForPosition(array $array, int $position): int {
    $nb = [0 => 0, 1 => 0];
    foreach ($array as $binary) {
        $binary = str_split($binary);

        $nb[$binary[$position]]++;
    }

    return $nb[0] > $nb[1] ? 0 : 1;
}

function reduceArray(array $array, int $keep, int $position): array {
    foreach ($array as $key => $value) {
        $arrayValue = str_split($value);

        if ($arrayValue[$position] != $keep) {
            unset($array[$key]);
        }
    }

    return $array;
}

$maxArray = $array;
for ($i = 0; $i < 12; $i++) {
    $max = getMaxForPosition($maxArray, $i);
    $maxArray = reduceArray($maxArray, $max, $i);
}
$oxygen = array_pop($maxArray);

$minArray = $array;
for ($i = 0; $i < 9; $i++) {
    $max = getMaxForPosition($minArray, $i);
    $min = ($max == 1) ? 0 : 1;
    $minArray = reduceArray($minArray, $min, $i);
}
$co2 = array_pop($minArray);

print 'Oxygen bin: '.$oxygen;
print PHP_EOL;
print 'Oxygen: '.bindec($oxygen);
print PHP_EOL;
print 'CO2 bin: '.$co2;
print PHP_EOL;
print 'CO2: '.bindec($co2);
print PHP_EOL;
print 'Result: '.(bindec($oxygen) * bindec($co2)).PHP_EOL;
