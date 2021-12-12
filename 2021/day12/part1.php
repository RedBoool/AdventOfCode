<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

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

function explore(array $map, string $key, string $path): int
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
        if (isLower($key)) {
            unset($currentMap[$key]);
        } else {
            unset($currentMap[$key][$nextKey]);
        }

        $result += explore($currentMap, $next, $path);
    }

    return $result;
}

function isLower(string $key): bool
{
    return $key === strtolower($key);
}

// Create map
$map = [];
foreach ($array as $path) {
    list($from, $to) = explode("-", $path);

    addToMap($map, $from, $to);
    addToMap($map, $to, $from);
}

// Recursively explore the map
$result = explore($map, 'start', '');

print 'Result: '.$result.PHP_EOL;
