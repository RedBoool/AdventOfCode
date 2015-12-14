<?php
/**
 * Part 1 & 2
 *
 * @param array   $reindeerList
 * @param integer $stopTime
 *
 * @return array
 */
function getPosition($reindeerList, $stopTime) {
    $result = array();
    foreach ($reindeerList as $reindeerName => $reindeer) {
        $nbCycle = intval($stopTime / ($reindeer['duration'] + $reindeer['rest']));
        $current = ($stopTime % ($reindeer['duration'] + $reindeer['rest']));

        $result[$reindeerName] = $nbCycle * $reindeer['duration'] * $reindeer['speed'] + ($current > $reindeer['duration'] ? $reindeer['duration'] : $current) * $reindeer['speed'];
    }

    return $result;
}

/**
 * Part 2 only
 *
 * @return array
 */
function getReindeerList() {
    $file = file_get_contents('input.txt');
    $lineList = explode("\n", $file);

    $pattern = '#(\w+) can fly (\d+) km/s for (\d+) seconds, but then must rest for (\d+) seconds.#';
    $reindeerList = array();
    foreach ($lineList as $line) {
        preg_match($pattern, $line, $match);
//        print_r($match);
        $reindeerList[$match[1]] = array('speed' => $match[2], 'duration' => $match[3], 'rest' => $match[4], 'score' => 0);
    }

    return $reindeerList;
}

/**
 * Part 2 only
 *
 * @param array   $reindeerList
 * @param integer $stopTime
 *
 * @return mixed
 */
function getScore($reindeerList, $stopTime) {
    for ($i = 1; $i <= $stopTime; $i++) {
        $positionList = getPosition($reindeerList, $i);

        $max = max($positionList);
        foreach ($positionList as $reindeer => $position) {
            if ($position === $max) {
                if (empty($score[$reindeer])) {
                    $score[$reindeer] = 0;
                }
                $score[$reindeer]++;
            }
        }
    }

    return $score;
}

$stopTime = 2503;

// Part 1
$reindeerListPart1 = array(
    'comet' => array('speed' => 14, 'duration' => 10, 'rest' => 127, 'score' => 0,),
    'dancer' => array('speed' => 16, 'duration' => 11, 'rest' => 162, 'score' => 0,),
);
$positionList = getPosition($reindeerListPart1, $stopTime);
print 'Part1: '.max($positionList);
print PHP_EOL;

// Part 2
$reindeerListPart2 = getReindeerList();
$score = getScore($reindeerListPart2, 2503);
print 'Part2: '.max($score);
print PHP_EOL;