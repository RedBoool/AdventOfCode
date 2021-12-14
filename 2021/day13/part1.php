<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function init(array $array): array
{
    $patternDot = '#(\d+),(\d+)#';
    $patternFold = '#fold along (x|y)=(\d+)#';
    $map = [];
    $toFold = [];
    foreach ($array as $value) {
        if (preg_match($patternDot, $value, $matches)) {
            addDot($map, $matches);
        } elseif (preg_match($patternFold, $value, $matches)) {
            addFold($toFold, $matches);
        }
    }

    return [$map, $toFold];
}

function addDot(array &$map, array $coordinate)
{
    $map[$coordinate[1]][$coordinate[2]] = true;
}

function addFold(array &$toFold, array $instruction)
{
    $toFold[] = ['axis' => $instruction[1], 'position' => $instruction[2]];
}

function fold(array $map, array $fold): array
{
    if ($fold['axis'] == 'x') {
        $map = foldY($map, $fold['position']);
    } elseif ($fold['axis'] == 'y') {
        $map = foldX($map, $fold['position']);
    } else {
        print 'We have a problem'.PHP_EOL;
        exit;
    }

    return $map;
}

function foldX(array $map, int $whereToFold): array
{
    foreach ($map as $x => $line) {
        foreach ($line as $y => $value) {
            if ($y > $whereToFold) {
                $distance = $y - $whereToFold;
                $map[$x][$y - $distance * 2] = true;
                unset($map[$x][$y]);
            }
        }
    }

    return $map;
}

function foldY(array $map, int $whereToFold): array
{
    foreach ($map as $x => $line) {
        foreach ($line as $y => $value) {
            if ($x > $whereToFold) {
                $distance = $x - $whereToFold;
                $map[$x - $distance * 2][$y] = true;
                unset($map[$x][$y]);
            }
        }
        if (empty($map[$x])) {
            unset($map[$x]);
        }
    }

    return $map;
}

function getMapSize(array $map) {
    $maxX = $maxY = 0;
    foreach ($map as $x => $line) {
        if ($x > $maxX) {
            $maxX = $x;
        }
        foreach ($line as $y => $value) {
            if ($y > $maxY) {
                $maxY = $y;
            }
        }
    }

    return ['x' => $maxX, 'y' => $maxY];
}

function view($map): string {
    $mapSize = getMapSize($map);

    $display = '';
    for ($y = 0; $y <= $mapSize['y']; $y++) {
        for ($x = 0; $x <= $mapSize['x']; $x++) {
            if (!empty($map[$x][$y])) {
                $display .= '#';
            } else {
                $display .= '.';
            }
        }
        $display .= PHP_EOL;
    }

    return $display;
}

function getNbDot($map): int
{
    $nbDot = 0;
    foreach ($map as $line) {
        foreach ($line as $value) {
            $nbDot++;
        }
    }

    return $nbDot;
}

list($map, $toFold) = init($array);

foreach ($toFold as $currentFold) {
    $map = fold($map, $currentFold);
    break;
}

print getNbDot($map).PHP_EOL;