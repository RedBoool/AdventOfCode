<?php
/**
 * Advent of code - day 13
 */
class Day13 {
    private $people = array();
    private $best = '';

    /**
     * Entry point
     */
    public function main() {
        $todoList = $this->parse();

        // Part 1
        $this->goDeep($todoList, array());

        print 'Part1: '.$this->best;
        print PHP_EOL;

        // Part 2
        $this->addMe();
        $todoList['me'] = 'me';
        $this->best = '';
        $this->goDeep($todoList, array());

        print 'Part2: '.$this->best;
        print PHP_EOL;
    }

    /**
     * Parse file and return an array containing every relationship
     *
     * @return array $todoList
     */
    private function parse() {
        $file = file_get_contents('input.txt');
        $lineList = explode("\n", $file);

        $pattern = '#([\w]+) would (gain|lose) (\d+) happiness units by sitting next to ([\w]+)#';
        foreach ($lineList as $line) {
            preg_match($pattern, $line, $match);

            $people[$match[1]][$match[4]] = ($match[2] === 'lose' ? -1 : 1) * $match[3];
            $todoList[$match[1]] = $match[1];
        }

        $this->people = $people;

        return $todoList;
    }

    /**
     * Recursive function that go threw every possible seating arrangement
     *
     * @param array $todoList
     * @param array $doneList
     *
     * @return null
     */
    private function goDeep($todoList, $doneList) {
        if (empty($todoList)) {
            $sum = $this->getSum($doneList);

            if (empty($this->best)) {
                $this->best = $sum;
            } else {
                $this->best = max($this->best, $sum);
            }

            return;
        }

        foreach ($todoList as $todo) {
            $tmpDoneList = $doneList;
            $tmpTodoList = $todoList;

            $tmpDoneList[$todo] = $todo;
            unset($tmpTodoList[$todo]);

            $this->goDeep($tmpTodoList, $tmpDoneList);
        }

        return;
    }

    /**
     * Calculate the sum of happiness for a full table
     *
     * @param array $doneList
     *
     * @return integer $sum
     */
    private function getSum($doneList){
        $sum = 0;
        $i = 0;
        foreach($doneList as $key => $done) {
            if ($i === 0) {
                $first = $key;
                $previous = $key;
                $i++;
                continue;
            }

            $sum += $this->people[$key][$previous];
            $sum += $this->people[$previous][$key];

            $previous = $key;
        }

        $sum += $this->people[$key][$first];
        $sum += $this->people[$first][$key];

        return $sum;
    }

    /**
     * Add me for the second part
     */
    private function addMe() {
        foreach ($this->people as $people => $relation) {
            $this->people['me'][$people] = 0;
            $this->people[$people]['me'] = 0;
        }
    }
}

$day13 = new Day13();
$day13->main();