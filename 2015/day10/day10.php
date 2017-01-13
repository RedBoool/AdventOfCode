<?php
function lookAndSay($input) {
    $inputLen = strlen($input);

    $current = '';
    $howMany = 1;
    $output = '';
    for ($i = 0; $i < $inputLen; $i++) {
        if ($current === $input[$i]) {
            $howMany++;
        } else {
            if (!empty($current)) {
                $output .= strval($howMany).$current;
            }
            $current = $input[$i];
            $howMany = 1;
        }
    }
    $output .= strval($howMany).$current;

    return $output;
}

$input = '1113122113';
$nbRotationPart1 = 40;
$nbRotationPart2 = 50;
for ($i = 0; $i < $nbRotationPart2; $i++) {
    $input = lookAndSay($input);
    if ($i === ($nbRotationPart1 - 1)) {
        $outputPart1 = $input;
    }
}

print 'Part1: '.strlen($outputPart1);
print PHP_EOL;
print 'Part2: '.strlen($input);
print PHP_EOL;