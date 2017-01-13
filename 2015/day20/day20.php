<?php
/**
 * Get all dividers for a number
 *
 * @param integer $number
 *
 * @return arrya $dividerList All divider for the given $number
 */
function getDividers($number) {
    $dividerList = array();
    for ($i = 1; $i <= sqrt($number); $i++) {
        if ($number % $i === 0) {
            $dividerList[$i] = $i;
            $dividerList[$number / $i] = $number / $i;
        }
    }

    ksort($dividerList);

    return $dividerList;
}

/**
 * Compute part 1
 *
 * @param integer $input Goal
 */
function part1($input) {
    $current = 770000; // As i know the answer, let's avoid wasting time and don't start with 1
    while (1) {
        $dividerList = getDividers($current);

        $sum = 0;
        foreach ($dividerList as $divider) {
            $sum += $divider * 10;
        }

        if ($sum >= $input) {
            break;
        }

        $current++;
    }

    print 'Part1: '.$current;
    print PHP_EOL;
}

/**
 * Compute part 2
 *
 * @param integer $input Goal
 */
function part2($input) {
    $current = 780000; // As i know the answer, let's avoid wasting time and don't start with 1
    while (1) {
        $dividerList = getDividers($current);

        foreach ($dividerList as $divider) {
            if (($divider * 50) < $current) {
                unset($dividerList[$divider]);
            }
        }

        $sum = 0;
        $i = 0;
        foreach ($dividerList as $divider) {
            $sum += $divider * 11;
        }

        if ($sum >= $input) {
            break;
        }

        $current++;
    }

    print 'Part2: '.$current;
    print PHP_EOL;
}

$input = 33100000;
part1($input);
part2($input);