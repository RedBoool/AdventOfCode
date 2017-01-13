<?php
/**
 * @param string $str
 *
 * @return string
 */
function increaseString($str) {
    global $alphabet, $alphabetLen, $flippedAlphabet;

    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        if ($str[$i] != $alphabet[$alphabetLen - 1]) {
            $str[$i] = $alphabet[$flippedAlphabet[$str[$i]]+1];
            break;
        } else {
            $str[$i] = 'a';
        }
    }

    return $str;
}

/**
 * @param string $str
 *
 * @return bool
 */
function checkDoublePair($str) {
    $pair1 = '';

    for ($i = 1; $i < strlen($str); $i++) {
        if ($str[$i] == $str[$i - 1]) {
            $pair = $str[$i];
        }

        if (empty($pair1) && !empty($pair)) {
            $pair1 = $pair;
        } else if (!empty($pair1) && !empty($pair) && $pair1 != $pair) {
            return true;
        }
    }

    return false;
}

/**
 * @param string $str
 *
 * @return bool
 */
function checkSuite($str) {
    global $alphabet, $flippedAlphabet;

    for ($i = 2; $i < strlen($str); $i++) {
        if (!empty($alphabet[$flippedAlphabet[$str[$i]] - 1]) &&
            $str[$i - 1] === $alphabet[$flippedAlphabet[$str[$i]] - 1] &&
            !empty($alphabet[$flippedAlphabet[$str[$i]] - 2]) &&
            $str[$i - 2] === $alphabet[$flippedAlphabet[$str[$i]] - 2])
        {
            return true;
        }
    }

    return false;
}

/**
 * @param string $str
 *
 * @return bool
 */
function check($str) {
    return checkDoublePair($str) && checkSuite($str);
}

/**
 * @param array  $prohibitedLetterList
 * @param string $str
 *
 * @return string
 */
function cleanString($prohibitedLetterList, $str) {
    $fill = '';

    for ($i = 0; $i < strlen($str); $i++) {
        foreach ($prohibitedLetterList as $prohibitedLetter => $prohibitedLetterReplacement) {
            if (!empty($fill)) {
                $str[$i] = $fill;
            } else if ($str[$i] === $prohibitedLetter) {
                $str[$i] = $prohibitedLetterReplacement;
                $fill = 'a';
                break;
            }
        }
    }

    return $str;
}

$alphabet = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
$alphabetLen = count($alphabet);
$flippedAlphabet = array_flip($alphabet);
$prohibitedLetter = array('i' => 'j', 'l' => 'm', 'o' => 'p');

$input = 'hxbxwxba';
while (true) {
    $input = cleanString($prohibitedLetter, $input);
    $input = increaseString($input);
    if (check($input)) {
        if (empty($part1)) {
            $part1 = $input;
        } else {
            $part2 = $input;
            break;
        }
    }
}

print 'Part1: '.$part1;
print PHP_EOL;
print 'Part2: '.$part2;
print PHP_EOL;