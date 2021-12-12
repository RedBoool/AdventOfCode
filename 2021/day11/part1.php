<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function initMap(array $array): array
{
    $map = [];
    foreach ($array as $key => $value) {
        for ($i = 0; $i < strlen($value); $i++) {
            $map[$key][$i] = $value[$i];
        }
    }

    return $map;
}

function doSteps(array $map): int
{
    print view($map).PHP_EOL;
    $flash = 0;
    for ($i = 0; $i < 100; $i++) {
        $flash += doStep($map);
        print view($map).PHP_EOL;
    }

    return $flash;
}

function doStep(array &$map): int
{
    doPart1($map);
    $nbFlash = doPart2($map);
    doPart3($map);

    return $nbFlash;
}

function doPart1(array &$map): void
{
    foreach ($map as $keyLine => $line) {
        foreach ($line as $key => $value) {
            $map[$keyLine][$key] += 1;
        }
    }
}

function doPart2(array &$map): int
{
    $done = [];
    $flash = 0;
    foreach ($map as $x => $line) {
        foreach ($line as $y => $value) {
            if ($map[$x][$y] > 9) {
                doFlash($map, $done, $flash, $x, $y);
            }
        }
    }
    return $flash;
}

function doPart3(array &$map): void
{
    foreach ($map as $x => $line) {
        foreach ($line as $y => $value) {
            if ($map[$x][$y] > 9) {
                $map[$x][$y] = 0;
            }
        }
    }
}

function doFlash(&$map, &$done, &$flash, $x, $y)
{
    if (!empty($done[$x][$y])) {
        return;
    }
    $done[$x][$y] = true;
    $flash++;

    for ($i = $x - 1; $i <= $x + 1; $i++) {
        for ($j = $y - 1; $j <= $y + 1; $j++) {
            if (isset($map[$i][$j])) {
                $map[$i][$j]++;
                if ($map[$i][$j] > 9) {
                    doFlash($map, $done, $flash, $i, $j);
                }
            }
        }
    }
}

function view($map): string
{
    $str = '';
    foreach ($map as $keyLine => $line) {
        foreach ($line as $key => $value) {
            $str .= ' '.$value;
        }
        $str .= "\n";
    }

    return $str;
}

$map = initMap($array);
$flash = doSteps($map);

print 'Result: '.$flash.PHP_EOL;
//print view($map);
//print_r($map);
