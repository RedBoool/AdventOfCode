<?php
$file = file_get_contents('input.txt');
$lineList = explode("\n", $file);

$resultPart1 = 0;
$resultPart2 = 0;
foreach ($lineList as $line) {
    $lineLen = strlen($line);

    // Part 1
    $patternListPart1 = array(
        '#\\\"#',
        '#\\\\x[0-9a-f]{2}#',
        '#[\\\\]{2}#',
    );
    $replacementListPart1 = array(
        '#',
        '#',
        '\\',
    );
    $newLinePart1 = preg_replace($patternListPart1, $replacementListPart1, substr($line, 1, -1));

    $resultPart1 += $lineLen - strlen($newLinePart1);

    // Part 2
    $patternListPart2 = array(
        '#\"#',
        '#\\\\#',
    );
    $replacementListPart2 = array(
        '##',
        '##',
    );
    $newLinePart2 = preg_replace($patternListPart2, $replacementListPart2, $line);
    $resultPart2 += strlen($newLinePart2) - $lineLen + 2;
}
print 'Part1: '.$resultPart1;
print PHP_EOL;
print 'Part2: '.$resultPart2;
print PHP_EOL;