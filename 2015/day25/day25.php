<?php
$initialValue = 20151125;
$row = 2947;
$column = 3029;

function getNumberOfIteration($row, $col) {
    $rangeRow = range(0, $row - 1);
    $result = array_sum($rangeRow) + 1;

    if ($col > 1) {
        $rangeCol = range($row + 1, $col + $row - 1);
        $result += array_sum($rangeCol);
    }

    return $result;
}

function getresult($nbIteration, $initialValue) {
    $result = $initialValue;
    for ($i = 1; $i < $nbIteration; $i++) {
        $result = $result * 252533 % 33554393;
    }

    return $result;
}

$nbIteration = getNumberOfIteration($row, $column);
$result = getresult($nbIteration, $initialValue);

print 'Part 1: '.$result;
print PHP_EOL;