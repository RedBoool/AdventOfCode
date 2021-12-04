<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

// Get draw list
function getDrawList($drawLine): array
{
    return explode(',', $drawLine);
}

// Prepare all grid
function prepareGrids(array $array): array
{
    while (!empty($array)) {
        $grids[] = prepareGrid($array);
    }

    return $grids;
}

// Prepare one grid
function prepareGrid(array &$array): array
{
    array_shift($array); // We have one empty line before each grid

    $grid = [];
    for ($i = 0; $i < 5; $i++) {
        $line = array_shift($array);
        $lineArray = preg_split('#\s+#', ltrim($line));
        for ($j = 0; $j < 5; $j++) {
            $grid[$i][$j] = $lineArray[$j];
        }
    }

    return $grid;
}

// Get the next number and add it to the grids
function drawNextNumber(string $number, array &$grids)
{
    foreach ($grids as &$grid) {
        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if ($grid[$i][$j] == $number) {
                    $grid[$i][$j] = '*'.$grid[$i][$j];
                }
            }
        }
    }

}

function checkGrids(array &$grids): ?array
{
    foreach ($grids as $key => $grid) {
        if (checkLines($grid) || checkColumns($grid)) {
            if (count($grids) === 1) {
                return array_shift($grids);
            }
            unset($grids[$key]);
        }
    }

    return null;
}

function checkLines(array $grid): bool
{
    for ($i = 0; $i < 5; $i++) {
        $isOk = true;
        for ($j = 0; $j < 5; $j++) {
            if ($grid[$i][$j][0] !== '*') {
                continue 2;
            }
        }
        if ($isOk) {
            return true;
        }
    }

    return false;
}

function checkColumns(array $grid): bool
{
    for ($i = 0; $i < 5; $i++) {
        $isOk = true;
        for ($j = 0; $j < 5; $j++) {
            if ($grid[$j][$i][0] !== '*') {
                continue 2;
            }
        }
        if ($isOk) {
            return true;
        }
    }

    return false;
}

function calculateResult(int $number, array $grid)
{
    $gridSum = 0;
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if ($grid[$i][$j][0] != '*') {
                $gridSum += intval(ltrim($grid[$i][$j], '*'));
            }
        }
    }

    return $number * $gridSum;
}

$draw = getDrawList(array_shift($array));
$grids = prepareGrids($array);

$i = 0;
$grid = $number = null;
foreach ($draw as $number) {
    drawNextNumber($number, $grids);
    if ($i > 5) {
        $grid = checkGrids($grids);
        if ($grid != null) {
            break;
        }
    }
    $i++;
}

$result = calculateResult(intval($number), $grid);

print 'Result: '.$result.PHP_EOL;