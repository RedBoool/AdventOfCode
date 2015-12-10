<?php
$file = file_get_contents('input.txt');
$fileArray = explode("\n", $file);

// Part 1
$vowelList = array('a', 'e', 'i', 'o', 'u'); // y is not considered as a vowel here
$excludeStringList = array('ab', 'cd', 'pq', 'xy');
$resultPart1 = 0;
foreach ($fileArray as $string) {
    $stringLen = strlen($string);

    // Check1 - At least 3 vowels
    $vowelFound = 0;
    for ($i = 0; $i < $stringLen; $i++) {
        if (in_array($string[$i], $vowelList)) {
            $vowelFound++;
        }
    }
    if ($vowelFound < 3) {
        continue;
    }

    // Check2 - Double letter
    $doubleFound = false;
    for ($i = 1; $i < $stringLen; $i++) {
        if ($string[$i] === $string[$i - 1]) {
            $doubleFound = true;
        }
    }
    if (!$doubleFound) {
        continue;
    }

    // Check 3 - Not in string
    foreach($excludeStringList as $excludeString) {
        if (strpos($string, $excludeString) !== false) {
            continue 2;
        }
    }

    $resultPart1++;
}

print 'Part1: '.$resultPart1;
print PHP_EOL;

// Part 2
$resultPart2 = 0;
foreach ($fileArray as $string) {
    $stringLen = strlen($string);

    // Check1 - Double pair
    $doubleFound = false;
    for ($i = 0; $i < $stringLen - 3; $i++) {
        $sub1 = substr($string, $i, 2);
        $sub2 = substr($string, $i + 2);

        if (strpos($sub2, $sub1) !== false) {
            $doubleFound = true;
        }
    }
    if ($doubleFound === false) {
        continue;
    }

    // Check2 - One letter repeated with something else between (Like x in xyx)
    $doubleFound = false;
    for ($i = 2; $i < $stringLen; $i++) {
        if ($string[$i] === $string[$i - 2]) {
            $doubleFound = true;
        }
    }
    if (!$doubleFound) {
        continue;
    }

    $resultPart2++;
}

print 'Part2: '.$resultPart2;
print PHP_EOL;