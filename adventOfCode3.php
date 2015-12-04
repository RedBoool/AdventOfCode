<?php
$file = file_get_contents('adventOfCode3_input.txt');

$xPart1 = 0;
$yPart1 = 0;
$x1Part2 = 0;
$x2Part2 = 0;
$y1Part2 = 0;
$y2Part2 = 0;
$strLen = strlen($file);
$mapPart1[0][0] = 1;
$mapPart2[0][0] = 1;
for ($i = 0; $i < $strLen; $i++) {
    // Part 1
    if ($file[$i] == '^') {
        $yPart1++;
    } elseif ($file[$i] == 'v') {
        $yPart1--;
    } elseif ($file[$i] == '<') {
        $xPart1--;
    } elseif ($file[$i] == '>') {
        $xPart1++;
    }
    $mapPart1[$xPart1][$yPart1] = empty($mapPart1[$xPart1][$yPart1]) ? 1 : $mapPart1[$xPart1][$yPart1]++;

    // Part 2
    if ($i % 2 == 0) {
        if ($file[$i] == '^') {
            $y2Part2++;
        } elseif ($file[$i] == 'v') {
            $y2Part2--;
        } elseif ($file[$i] == '<') {
            $x2Part2--;
        } elseif ($file[$i] == '>') {
            $x2Part2++;
        }
        $mapPart2[$x2Part2][$y2Part2] = empty($mapPart2[$x2Part2][$y2Part2]) ? 1 : $mapPart2[$x2Part2][$y2Part2]++;
    } else {
        if ($file[$i] == '^') {
            $y1Part2++;
        } elseif ($file[$i] == 'v') {
            $y1Part2--;
        } elseif ($file[$i] == '<') {
            $x1Part2--;
        } elseif ($file[$i] == '>') {
            $x1Part2++;
        }
        $mapPart2[$x1Part2][$y1Part2] = empty($mapPart2[$x1Part2][$y1Part2]) ? 1 : $mapPart2[$x1Part2][$y1Part2]++;
    }
}

// Part 1
$sumPlacesPart1 = 0;
foreach ($mapPart1 as $mapPart1X) {
    $sumPlacesPart1 += count($mapPart1X);
}

print 'Part1:'.$sumPlacesPart1;
print PHP_EOL;

// Part 2
$sumPlacesPart2 = 0;
foreach ($mapPart2 as $mapPart2X) {
    $sumPlacesPart2 += count($mapPart2X);
}

print 'Part2:'.$sumPlacesPart2;
print PHP_EOL;