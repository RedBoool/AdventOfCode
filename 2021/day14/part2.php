<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function init($array):array
{
    $i = 0;
    $input = '';
    $pairList = [];
    foreach ($array as $value) {
        if ($i === 0) {
            $input = $value;
        } elseif ($i > 1) {
            $pair = explode(' -> ', $value);
            $pairList[$pair[0]] = $pair[1];
        }
        $i++;
    }

    return [$input, $pairList];
}

function recursiveCount(string $input, array $pairList, int $depth, array &$cache): array
{
    if ($depth >= 40) {
        return getNb($input);
    }

    $nb = [];
    for ($i = 1; $i < strlen($input); $i++) {
        // ac => abc
        $start = $input[$i - 1];
        $add = $pairList[$input[$i - 1].$input[$i]];
        $end = $input[$i];

        // ab
        if (empty($cache[$depth+1][$start.$add])) {
            $cache[$depth+1][$start.$add] = recursiveCount($start.$add, $pairList, $depth+1, $cache);
        }
        $nb = merge($nb, $cache[$depth+1][$start.$add]);

        // bc
        if (empty($cache[$depth+1][$add.$end])) {
            $cache[$depth+1][$add.$end] = recursiveCount($add.$end, $pairList, $depth+1, $cache);
        }
        $nb = merge($nb, $cache[$depth+1][$add.$end]);
    }

    return $nb;
}

function getNb(string $str): array
{
    $nb = [];
    for ($i = 1; $i < strlen($str); $i++) {
        if (empty($nb[$str[$i]])) {
            $nb[$str[$i]] = 1;
        } else {
            $nb[$str[$i]]++;
        }
    }

    return $nb;
}

function merge(array $a, array $b)
{
    foreach ($b as $key => $value) {
        if (!empty($a[$key])) {
            $a[$key] += $value;
        } else {
            $a[$key] = $value;
        }
    }

    return $a;
}

list($input, $pairList) = init($array);

$cache = [];
$nb = recursiveCount($input, $pairList, 0, $cache);

$result = max($nb) - min($nb);
print 'Result: '.$result.PHP_EOL;
