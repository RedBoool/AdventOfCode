<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);
sort($array);

function addToMap(array &$map, string $key, string $value): void
{
    if ($key === 'end') {
        return;
    }
    if ($value === 'start') {
        return;
    }
    $map[$key][] = $value;
}

function explore(array $map, string $key, bool $twice, string $path, array $visited): int
{
    $path .= $key.',';

    if ($key === 'end') {
        print rtrim($path, ',').PHP_EOL;
        return 1;
    }

    if (empty($map[$key])) {
        return 0;
    }

    $result = 0;
    foreach ($map[$key] as $nextKey => $next) {
        $currentMap = $map;
        $currentVisited = $visited;

        if (empty($currentVisited[$key])) {
            $currentVisited[$key] = 1;
        } else {
            $currentVisited[$key]++;
        }

        if (isLower($key)) {
            if ($twice) {
                unset($currentMap[$key]);
            }
            if ($currentVisited[$key] > 1) {
                $currentMap = cleanMap($currentMap, $currentVisited);
                $twice = true;
            }
        } else {
            if ($twice) {
                unset($currentMap[$key][$nextKey]);
            }
        }

        $result += explore($currentMap, $next, $twice, $path, $currentVisited);
    }

    return $result;
}

function isLower(string $key): bool
{
    return $key === strtolower($key);
}

function cleanMap($map, $visited): array
{
    foreach ($map as $mapKey => $array) {
        foreach ($array as $key => $value) {
            if (isLower($value) && !empty($visited[$value])) {
                unset($map[$mapKey][$key]);
                unset($map[$value]);
            }
        }
        if (empty($map[$mapKey])) {
            unset($map[$mapKey]);
        }
    }

    return $map;
}

// Create map
$map = [];
foreach ($array as $path) {
    list($from, $to) = explode("-", $path);

    addToMap($map, $from, $to);
    addToMap($map, $to, $from);
}

// Recursively explore the map
$result = explore($map, 'start', false, '', []);

print 'Result: '.$result.PHP_EOL;
