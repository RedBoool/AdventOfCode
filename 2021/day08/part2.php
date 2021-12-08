<?php
$string = file_get_contents('input.txt');
$array = explode("\n", $string);

function decodeMap(array $array): array
{
    $map = [];
    foreach ($array as $key => $value) {
        $len = strlen($value);
        if ($len === 2) {
            $map[1] = sortString($value);
            unset($array[$key]);
        } elseif ($len === 3) {
            $map[7] = sortString($value);
            unset($array[$key]);
        } elseif ($len === 4) {
            $map[4] = sortString($value);
            unset($array[$key]);
        } elseif ($len === 7) {
            $map[8] = sortString($value);
            unset($array[$key]);
        }
    }

    foreach ($array as $value) {
        $len = strlen($value);
        if ($len === 5) {
            if (contains($map[1], $value) === 2) {
                $map[3] = sortString($value);
            } elseif (contains($map[4], $value) === 3) {
                $map[5] = sortString($value);
            } else {
                $map[2] = sortString($value);
            }
        } elseif ($len === 6) {
            if (contains($map[4], $value) === 4) {
                $map[9] = sortString($value);
            } elseif (contains($map[1], $value) === 2) {
                $map[0] = sortString($value);
            } else {
                $map[6] = sortString($value);
            }
        }
    }

    return $map;
}

// Sort string (bac -> abc)
function sortString(string $string)
{
    $stringParts = str_split($string);
    sort($stringParts);
    return implode($stringParts);
}

// Return the number of letter of $a are in $b ?
function contains(string $a, string $b): int
{
    $nb = 0;
    foreach (str_split($a) as $aValue) {
        foreach (str_split($b) as $bValue) {
            if ($aValue === $bValue) {
                $nb++;
                continue 2;
            }
        }
    }

    return $nb;
}

$result = 0;
foreach ($array as $line) {
    $exploded = explode('|', $line);
    $digitMap = trim($exploded[0]);
    $digitMap = decodeMap(explode(' ', $digitMap));
    $digitMap = array_flip($digitMap);

    $digits = trim($exploded[1]);
    $digits = explode(' ', $digits);
    $currentDigit = '';
    foreach ($digits as $digit) {
        $currentDigit .= $digitMap[sortString($digit)];
    }
    $result += intval($currentDigit);
}

print 'Result: '.$result.PHP_EOL;
