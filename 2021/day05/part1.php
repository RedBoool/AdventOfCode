<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function addWind(array &$grid, string $wind)
{
    $pattern = '#^(\d+),(\d+) -> (\d+),(\d+)$#';
    preg_match($pattern, $wind, $matches);

    array_shift($matches);
    list($fromX, $fromY, $toX, $toY) = $matches;

    if ($fromX != $toX && $fromY != $toY) {
        // Ignore diagonal
    } elseif ($fromX < $toX) {
        for ($x = $fromX; $x <= $toX; $x++) {
            addWindDot($grid, $x, $fromY);
        }
    } elseif ($fromX > $toX) {
        for ($x = $fromX; $x >= $toX; $x--) {
            addWindDot($grid, $x, $fromY);
        }
    } elseif ($fromY < $toY) {
        for ($y = $fromY; $y <= $toY; $y++) {
            addWindDot($grid, $fromX, $y);
        }
    } elseif ($fromY > $toY) {
        for ($y = $fromY; $y >= $toY; $y--) {
            addWindDot($grid, $fromX, $y);
        }
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