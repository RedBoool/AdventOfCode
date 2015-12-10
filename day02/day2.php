<?php
$file = file_get_contents('input.txt');

$pattern = '#(\d+)x(\d+)x(\d+)#';
preg_match_all($pattern, $file, $matches);

$wrappingPaperFullSize = 0;
$ribbonFullSize = 0;
foreach ($matches[0] as $key => $match) {
    $l = $matches[1][$key];
    $w = $matches[2][$key];
    $h = $matches[3][$key];

    // Wrapping paper
    $wrappingPaperPart1 = 2*$l*$w;
    $wrappingPaperPart2 = 2*$w*$h;
    $wrappingPaperPart3 = 2*$h*$l;

    $wrappingPaperMin = min($wrappingPaperPart1, $wrappingPaperPart2, $wrappingPaperPart3);

    $wrappingPaperSize = $wrappingPaperPart1 + $wrappingPaperPart2 + $wrappingPaperPart3 + ($wrappingPaperMin / 2);
    $wrappingPaperFullSize += $wrappingPaperSize;

    // Ribbon
    $maxRibbon = max($l, $w, $h);
    if ($maxRibbon == $l) {
        $ribbonPart1 = $w*2+$h*2;
    } else if ($maxRibbon == $w) {
        $ribbonPart1 = $l*2+$h*2;
    } else if ($maxRibbon == $h) {
        $ribbonPart1 = $l*2+$w*2;
    }
    $ribbonPart2 = $l*$w*$h;

    $ribbonSize = $ribbonPart1 + $ribbonPart2;
    $ribbonFullSize += $ribbonSize;
}
print 'WrappingPaperFullSize: '.$wrappingPaperFullSize;
print PHP_EOL;
print 'RibbonFullSize: '.$ribbonFullSize;
print PHP_EOL;
