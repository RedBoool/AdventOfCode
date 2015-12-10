<?php
$string = file_get_contents('input.txt');

$cpt = 0;
$strLen = strlen($string);
$isOk = true;
for ($i = 0; $i < $strLen; $i++) {
    if ($string[$i] == '(') {
        $cpt++;
    } else if ($string[$i] == ')') {
        $cpt--;
    }
    if ($cpt < 0 && $isOk === true) {
        print 'First underground: '.($i+1);
        print PHP_EOL;
        $isOk = false;
    }
}
print 'Result: '.$cpt;
print PHP_EOL;
