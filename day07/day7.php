<?php
class Day7 {
    private $actionList = array();
    private $valueList = array();

    public function main() {
        foreach ($this->getFileContent() as $line) {
            $pattern = '#^(.*?) -> (.*?)$#';
            preg_match($pattern, $line, $match);

            $this->actionList[$match[2]] = $match[1];
        }

        // Part 1
        $part1 = $this->get('a');
        // Part 2
        unset($this->valueList);
        $this->valueList['b'] = $part1;
        $part2 = $this->get('a');

        print 'Part1: '.$part1;
        print PHP_EOL;
        print 'Part2: '.$part2;
        print PHP_EOL;
    }

    /**
     * @return array
     */
    private function getFileContent() {
        $file = file_get_contents('input.txt');
        $fileArray = explode("\n", $file);

        return $fileArray;
    }

    /**
     * @param mixed $key
     *
     * @return integer
     */
    private function get($key) {
        if (!empty($this->valueList[$key])) {
            return $this->valueList[$key];
        }

        if ($this->isValue($key)) {
            return $key;
        }

        if (!isset($this->actionList[$key])) {
            print 'KEY: '.$key;
            print PHP_EOL;
            print 'Houston, we got a problem';
            print PHP_EOL;
            exit();
        }

        $pattern = '#^(?:(?:(\w+)\s+)?(\w+)\s)?(\w+)$#';
        preg_match($pattern, $this->actionList[$key], $match);

        if (!empty($match[2]) && $match[2] === 'AND') {
            $tmp = $this->get($match[1]) & $this->get($match[3]);
            $this->valueList[$key] = $tmp;
            return $tmp;
        } else if (!empty($match[2]) && $match[2] === 'OR') {
            $tmp = $this->get($match[1]) | $this->get($match[3]);
            $this->valueList[$key] = $tmp;
            return $tmp;
        } else if (!empty($match[2]) && $match[2] === 'NOT') {
            $tmp = (65535 - $this->get($match[3]));
            $this->valueList[$key] = $tmp;
            return $tmp;
        } else if (!empty($match[2]) && $match[2] === 'LSHIFT') {
            $tmp = $this->get($match[1]) << $this->get($match[3]);
            $this->valueList[$key] = $tmp;
            return $tmp;
        } else if (!empty($match[2]) && $match[2] === 'RSHIFT') {
            $tmp = $this->get($match[1]) >> $this->get($match[3]);
            $this->valueList[$key] = $tmp;
            return $tmp;
        } else if (empty($match[1]) && empty($match[2]) && isset($match[3]) && $this->isValue($match[3])) {
            $tmp = intval($match[3]);
            $this->valueList[$key] = $tmp;
            return $tmp;
        } else if (empty($match[1]) && empty($match[2]) && isset($match[3])) {
            $tmp = $this->get($match[3]);
            $this->valueList[$key] = $tmp;
            return $tmp;
        }
    }

    /**
     * Ex: 123 -> x
     */
    private function isValue($str) {
        return $str === (string) intval($str);
    }
}

$day7 = new Day7();
$day7->main();