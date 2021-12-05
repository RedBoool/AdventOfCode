<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function addWind(array &$grid, string $wind)
{
    $pattern = '#^(\d+),(\d+) -> (\d+),(\d+)$#';
    preg_match($pattern, $wind, $matches);

    array_shift($matches);
    list($fromX, $fromY, $toX, $toY) = $matches;

    if ($fromX > $toX) {
        $spaceX = $fromX - $toX;
        $wayX = -1;
    } elseif ($fromX < $toX) {
        $spaceX = $toX - $fromX;
        $wayX = 1;
    } else {
        $spaceX = 0;
        $wayX = 0;
    }

    if ($fromY > $toY) {
        $spaceY = $fromY - $toY;
        $wayY = -1;
    } elseif ($fromY < $toY) {
        $spaceY = $toY - $fromY;
        $wayY = 1;
    } else {
        $spaceY = 0;
        $wayY = 0;
    }

    if ($spaceX > $spaceY) {
        $space = $spaceX;
    } else {
        $space = $spaceY;
    }

    for ($i = 0; $i <= $space ; $i++) {
        addWindDot($grid, $fromX + $i * $wayX, $fromY + $i * $wayY);
    }

}

function addWindDot(array &$grid, int $x, int $y)
{
    if (empty($grid[$x][$y])) {
        $grid[$x][$y] = 1;
    } else {
        $grid[$x][$y]++;
    }
}

function getResult($grid): int
{
    $count = 0;
    foreach ($grid as $line) {
        foreach ($line as $value) {
            if ($value > 1) {
                $count++;
            }
        }
    }

    return $count;
}

$grid = [];
foreach ($array as $wind) {
    addWind($grid, $wind);
}

$result = getResult($grid);

print 'Result: '.$result.PHP_EOL;
