<?php
class Day23 {
    private $a = 0;
    private $b = 0;
    private $currentPosition = 0;

    public function main() {
        $instructionList = $this->getInstructionList();

        $this->execute($instructionList);
        print 'Part1: ';
        print $this->b;
        print PHP_EOL;

        $this->a = 1;
        $this->b = 0;
        $this->execute($instructionList);
        print 'Part2: ';
        print $this->b;
        print PHP_EOL;
    }

    private function getInstructionList() {
        $file = file_get_contents('input.txt');

        $pattern = '#(\w{3})\s+(?:[\+]?)([\-\w\d]+)(?:,\s+(?:[\+]?)([\-\w\d]+))?#'; //
        preg_match_all($pattern, $file, $matchList);

        foreach ($matchList[0] as $key => $match) {
            $instructionList[$key] = array('instruction' => $matchList[1][$key], 'param1' => $matchList[2][$key], 'param2' => $matchList[3][$key]);

            if ($instructionList[$key]['instruction'] === 'jio') {
                $instructionList[$key]['param2'] = intval($instructionList[$key]['param2']);
            } else if ($instructionList[$key]['instruction'] === 'jie') {
                $instructionList[$key]['param2'] = intval($instructionList[$key]['param2']);
            } else if ($instructionList[$key]['instruction'] === 'jmp') {
                $instructionList[$key]['param1'] = intval($instructionList[$key]['param1']);
            }
        }

        return $instructionList;
    }

    private function execute($instructionList) {
        for ($i = $this->currentPosition; $i < count($instructionList); $i) {
            $jmp = $this->{$instructionList[$i]['instruction']}($instructionList[$i]['param1'], $instructionList[$i]['param2']);
            $i += $jmp;
        }
    }

    private function hlf($r) {
        $this->$r /= 2;

        return 1;
    }

    private function tpl($r) {
        $this->$r *= 3;

        return 1;
    }

    private function inc($r) {
        $this->$r++;

        return 1;
    }

    private function jmp($offset) {
        return $offset;
    }

    private function jie($r, $offset) {
        if ($this->$r % 2 === 0) {
            return $offset;
        } else {
            return 1;
        }
    }

    private function jio($r, $offset) {
        if ($this->$r === 1) {
            return $offset;
        } else {
            return 1;
        }
    }
}

$day23 = new Day23();
$day23->main();