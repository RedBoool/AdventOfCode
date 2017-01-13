<?php
class Day24 {
    const NUMBER_OF_GROUP = 4;

    private $maxDepth;

    private $possibleGroup = array();

    public function main() {
        $boxList = $this->getPackageWeight();

        // If we want less box, we have to take big ones. So let's start with big box first
        rsort($boxList);

        // Initiate maxDepth
        $this->maxDepth = count($boxList);

        // Let's have requested weight for each group
        $total = $this->getTotalPackageWeight($boxList);

        $numberOfGroupPart1 = 3;
        $groupSize = $total / $numberOfGroupPart1;

        $this->fillGroup($groupSize, $boxList);

        $bestEQ = $this->getBestEQ();
        print 'Part1: '.$bestEQ.PHP_EOL;

        $numberOfGroupPart2 = 4;
        $groupSize = $total / $numberOfGroupPart2;

        $this->fillGroup($groupSize, $boxList);

        $bestEQ = $this->getBestEQ();
        print 'Part2: '.$bestEQ.PHP_EOL;
    }

    private function getPackageWeight() {
        $file = file_get_contents('input.txt');
        $boxList = explode("\n", $file);

        return $boxList;
    }

    private function getTotalPackageWeight($boxList) {
        return array_sum($boxList);
    }

    private function fillGroup($boxSizeLeft, array $todoList, array $doneList = array(), $depth = 0) {
        if ($depth > $this->maxDepth) {
            return;
        }

        foreach ($todoList as $todoKey => $todo) {
            $currentBoxSizeLeft = $boxSizeLeft - $todo;
            if ($currentBoxSizeLeft > 0) {
                // Didn't reach weight, we go deeper
                $currentTodoList = $todoList;
                unset($currentTodoList[$todoKey]);

                $currentDoneList = $doneList;
                $currentDoneList[] = $todo;

                $this->fillGroup($currentBoxSizeLeft, $currentTodoList, $currentDoneList, $depth + 1);
            } else if ($currentBoxSizeLeft === 0) {
                // Yes, we've got a result
                $doneList[] = $todo;

                // Is it the shortest we got ?
                $nbElement = count($doneList) - 1;
                if (empty($this->maxDepth)) {
                    $this->maxDepth = $nbElement;
                } else if ($this->maxDepth >= $nbElement) {
                    $this->possibleGroup = array();
                    $this->maxDepth = $nbElement;
                }

                sort($doneList);
                if (!in_array($doneList, $this->possibleGroup)) {
                    $this->possibleGroup[] = $doneList;
                }
            } else {
                // Oups, to much weight
                continue;
            }
        }
    }

    private function getBestEQ() {
        $result = '';

        foreach($this->possibleGroup as $packageList) {
            $currentResult = 1;
            foreach ($packageList as $package) {
                $currentResult *= $package;
            }

            if (empty($result)) {
                $result = $currentResult;
            } else {
                $result = min($result, $currentResult);
            }
        }

        return $result;
    }
}

$day24 = new Day24();
$day24->main();
