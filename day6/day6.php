<?php
/**
 * Init the board setting every light to off
 *
 * @return array $map
 */
function initPart1() {

    $map = array();
    $oneLine = array_fill(0, 1000, false);
    for ($i = 0; $i < 1000; $i++) {
        $map[$i] = $oneLine;
    }

    return $map;
}

/**
 * Init the board setting every light to off
 *
 * @return array $map
 */
function initPart2() {

    $map = array();
    $oneLine = array_fill(0, 1000, 0);
    for ($i = 0; $i < 1000; $i++) {
        $map[$i] = $oneLine;
    }

    return $map;
}

/**
 * Read file and return an array containing each line
 *
 * @return array $fileArray
 */
function getFile() {
    $file = file_get_contents('input.txt');
    $fileArray = explode("\n", $file);

    return $fileArray;
}

/**
 * Transform instruction to an array
 *
 * @param string $instruction
 *
 * @return array Ex('action' => 'on', 'startx' => 887, 'stary' => 9, 'endx' => 959, 'endy' => 629)
 */
function readInstruction($instruction) {
    $pattern = '#(?:turn )?(?<action>on|off|toggle) (?<startX>\d+),(?<startY>\d+) through (?<endX>\d+),(?<endY>\d+)#';
    preg_match($pattern, $instruction, $match);

    return $match;
}

/**
 * Do the switch on or switch off action
 *
 * @param array   $mapPart1
 * @param array   $mapPart2
 * @param string  $action
 * @param integer $startX
 * @param integer $startY
 * @param integer $endX
 * @param integer $endY
 */
function switchOnOff(& $mapPart1, & $mapPart2, $action, $startX, $startY, $endX, $endY) {
    for ($x = $startX; $x <= $endX; $x++) {
        for ($y = $startY; $y <= $endY; $y++) {
            // Part 1
            $mapPart1[$x][$y] = ($action == 'on') ? true : false;

            // Part 2
            if ($action == 'off' && $mapPart2[$x][$y] > 0) {
                $mapPart2[$x][$y] -= 1;
            } else if ($action == 'on') {
                $mapPart2[$x][$y] += 1;
            }
        }
    }
}

/**
 * Do the toggle action
 *
 * @param array   $mapPart1
 * @param array   $mapPart2
 * @param integer $startX
 * @param integer $startY
 * @param integer $endX
 * @param integer $endY
 */
function toggle(& $mapPart1, & $mapPart2, $startX, $startY, $endX, $endY) {
    for ($x = $startX; $x <= $endX; $x++) {
        for ($y = $startY; $y <= $endY; $y++) {
            // Part 1
            $mapPart1[$x][$y] = ($mapPart1[$x][$y] == false) ? true : false;

            // Part 2
            $mapPart2[$x][$y] += 2;
        }
    }
}

/**
 * Check how many light are on
 *
 * @param array $map
 *
 * @return integer Number of light on
 */
function checkPart1($map) {
    $cpt = 0;
    for ($x = 0; $x < 1000; $x++) {
        for ($y = 0; $y < 1000; $y++) {
            if ($map[$x][$y] === true) {
                $cpt++;
            }
        }
    }

    return $cpt;
}

/**
 * Calculate total brightness
 *
 * @param array $map
 *
 * @return integer Brightness
 */
function checkPart2($map) {
    $cpt = 0;
    for ($x = 0; $x < 1000; $x++) {
        for ($y = 0; $y < 1000; $y++) {
            $cpt += $map[$x][$y];
        }
    }

    return $cpt;
}

/**
 * Main function
 */
function main() {
    $mapPart1 = initPart1();
    $mapPart2 = initPart2();
    $instructionList = getFile();

    $brightness = 0;
    foreach ($instructionList as $instruction) {
        $todo = readInstruction($instruction);

        if($todo['action'] === 'toggle') {
            toggle($mapPart1, $mapPart2, $todo['startX'], $todo['startY'], $todo['endX'], $todo['endY']);
        } else if ($todo['action'] === 'on' || $todo['action'] === 'off') {
            switchOnOff($mapPart1, $mapPart2, $todo['action'], $todo['startX'], $todo['startY'], $todo['endX'], $todo['endY']);
        }
    }

    print 'Part1: '.checkPart1($mapPart1).PHP_EOL;
    print 'Part2: '.checkPart2($mapPart2).PHP_EOL;
}

main();