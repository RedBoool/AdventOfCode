<?php
$ticketTap = array('children' => 3, 'cats' => 7, 'samoyeds' => 2, 'pomeranians' => 3, 'akitas' => 0, 'vizslas' => 0, 'goldfish' => 5, 'trees' => 3, 'cars' => 2, 'perfumes' => 1);

function getListOfSue() {
    $file = file_get_contents('input.txt');
    $lineList = explode("\n", $file);

    $pattern = '#^Sue (\d+): (\w+): (\d+), (\w+): (\d+), (\w+): (\d+)$#';
    $sueList = array();
    foreach ($lineList as $line) {
        preg_match($pattern, $line, $match);

        $sueList[$match[1]][$match[2]] = intval($match[3]);
        $sueList[$match[1]][$match[4]] = intval($match[5]);
        $sueList[$match[1]][$match[6]] = intval($match[7]);
    }

    return $sueList;
}

function part1($ticketTap, $sueList) {
    foreach ($sueList as $sueId => $sue) {
        $goodSue = 0;
        foreach ($sue as $key => $distinct) {
            if ($distinct === $ticketTap[$key]) {
                $goodSue++;
            }
        }

        if ($goodSue === 3) {
            return $sueId;
        }
    }

    return ;
}

function part2($ticketTap, $sueList) {
    foreach ($sueList as $sueId => $sue) {
        $goodSue = 0;
        foreach ($sue as $key => $distinct) {
            if (in_array($key, array('cats', 'trees'))) {
                if ($distinct > $ticketTap[$key]) {
                    $goodSue++;
                }
            } else if (in_array($key, array('pomeranians', 'goldfish'))) {
                if ($distinct < $ticketTap[$key]) {
                    $goodSue++;
                }
            } else if ($distinct === $ticketTap[$key]) {
                $goodSue++;
            }
        }

        if ($goodSue === 3) {
            return $sueId;
        }
    }

    return ;
}

$sueList = getListOfSue();
$part1 = part1($ticketTap, $sueList);
print 'Part1: '.$part1;
print PHP_EOL;
$part2 = part2($ticketTap, $sueList);
print 'Part2: '.$part2;
print PHP_EOL;

//print_r($sueList);
//print PHP_EOL;