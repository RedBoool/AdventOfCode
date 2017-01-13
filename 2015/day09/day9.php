<?php
$file = file_get_contents('input.txt');
$lineList = explode("\n", $file);

/**
 * @param string  $from
 * @param array   $todo
 * @param array   $done
 * @param integer $distance
 */
function visit($from, $todo, $done, $distance) {
    global $map, $distanceList;

    unset($todo[$from]);
    $done[$from] = $from;

    if (empty($todo)) {
        $distanceList[$distance] = $distance;
    } else {
        foreach ($todo as $city) {
            visit($city, $todo, $done, $distance + $map[$from][$city]);
        }
    }
}

foreach ($lineList as $line) {
    $pattern = '#(\w+)\sto\s(\w+)\s+=\s+(\d+)#';
    preg_match($pattern, $line, $match);

    $map[$match[1]][$match[2]] = $match[3];
    $map[$match[2]][$match[1]] = $match[3];

    $todo[$match[1]] = $match[1];
    $todo[$match[2]] = $match[2];
}

foreach ($map as $key => $value) {
    visit($key, $todo, array(), 0);
}

print 'Part1: ';
print min($distanceList);
print PHP_EOL;
print 'Part2: ';
print max($distanceList);
print PHP_EOL;