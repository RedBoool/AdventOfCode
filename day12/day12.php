<?php
$file = file_get_contents('input.txt');

// Part 1
$sum = 0;
$pattern = '#(-?\d+)#';
preg_match_all($pattern, $file, $matches);
foreach($matches[1] as $match) {
    $sum += intval($match);
}

print 'Part1: '.$sum;
print PHP_EOL;

// Part 2
$sum = 0;
$data = json_decode($file);
goDeep($data);

print 'Part2: '.$sum;
print PHP_EOL;

function goDeep($json) {
    global $sum;

    foreach ($json as $subJson) {
        if($subJson === 'red' && is_object($json)) {
            return;
        }
    }

    foreach ($json as $subJson) {
        if (is_array($subJson) || is_object($subJson)) {
            goDeep($subJson);
        } else if (!empty(intval($subJson))) {
            $sum += $subJson;
        }
    }
}