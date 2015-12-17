<?php
class Day17 {
    private $totalCapacity = 150;
    private $nbCombinationPart1 = 0;
    private $minBoxPart2;
    private $nbCombinationPart2 = 0;

    private function getBoxes() {
        $file = file_get_contents('input.txt');
        $boxList = explode("\n", $file);

        return $boxList;
    }

    private function goDeep($boxList, $capacityLeft, $deep = 0) {
        while (!empty($boxList)) {
            $box = array_shift($boxList);

            $currentLeftCapacity = $capacityLeft - $box;

            if ($currentLeftCapacity < 0) {
                continue;
            } else if ($currentLeftCapacity == 0) {
                if ($deep < $this->minBoxPart2) {
                    $this->nbCombinationPart2 = 1;
                    $this->minBoxPart2 = $deep;
                } else if ($deep == $this->minBoxPart2) {
                    $this->nbCombinationPart2++;
                }

                $this->nbCombinationPart1++;
                continue;
            }

            $this->goDeep($boxList, $currentLeftCapacity, $deep+1);
        }
    }

    public function main() {
        $boxList = $this->getBoxes();
        $this->minBoxPart2 = count($boxList);
        $this->goDeep($boxList, $this->totalCapacity);

        print 'Part1: '.$this->nbCombinationPart1;
        print PHP_EOL;
        print 'Part2: '.$this->nbCombinationPart2;
        print PHP_EOL;
    }
}

$day17 = new Day17();
$day17->main();
