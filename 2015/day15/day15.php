<?php
class Day15 {
    private $ingredientList = array();
    private $nbSpoon = 100;
    private $maxScore = 0;
    private $max500Cal = 0;

    private function getIngredients(array $fieldList) {
        $file = file_get_contents('input.txt');

        $pattern = '#(?P<name>\w+): capacity (?P<capacity>-?\d+), durability (?P<durability>-?\d+), flavor (?P<flavor>-?\d+), texture (?P<texture>-?\d+), calories (?P<calories>-?\d+)#';
        preg_match_all($pattern, $file, $matches);

        foreach ($matches[0] as $key => $match) {
            foreach ($fieldList as $field) {
                if (!isset($matches[$field][$key])) {
                    throw new Exception('Unable to find the requested field');
                }

                $ingredientList[$matches['name'][$key]][$field] = $matches[$field][$key];
            }
        }

        return $ingredientList;
    }

    private function cook($spoonLeft, $fieldList, $ingredientLeft, $ingredientUsed = array()) {
        $leftTodo = count($ingredientLeft);
        if (count($ingredientLeft) > 1) {
            $ingredient = array_shift($ingredientLeft);
            for ($i = $spoonLeft; $i >= 0; $i--) {
                $ingredient['amount'] = $i;
                $ingredientUsed[$leftTodo] = $ingredient;

                $this->cook($spoonLeft - $i, $fieldList, $ingredientLeft, $ingredientUsed);
            }
        } else {
            // Can't go deeper, so let's calculate
            $ingredient = array_shift($ingredientLeft);
            $ingredient['amount'] = $spoonLeft;
            $ingredientUsed[$leftTodo] = $ingredient;

            foreach ($ingredientUsed as $value) {
                foreach ($fieldList as $field) {
                    if (empty($result[$field])) {
                        $result[$field] = 0;
                    }
                    $result[$field] += $value[$field] * $value['amount'];
                }
            }

            $score = $this->getScore($fieldList, $result);
            $this->maxScore = max($this->maxScore, $score);

            if ($result['calories'] === 500) {
                $this->max500Cal = max($this->max500Cal, $score);
            }
        }
    }

    private function getScore($fieldList, $array) {
        $score = 1;

        unset($fieldList['calories']);
        foreach ($fieldList as $field) {
            $score *= $array[$field] > 0 ? $array[$field] : 0;
        }

        return $score;
    }

    public function main() {
        $fieldList = array(
            'capacity' => 'capacity',
            'durability' => 'durability',
            'flavor' => 'flavor',
            'texture' => 'texture',
            'calories' => 'calories',
        );
        $this->ingredientList = $this->getIngredients($fieldList);

        $this->cook($this->nbSpoon, $fieldList, $this->ingredientList);

        print 'Part1: '.$this->maxScore;
        print PHP_EOL;
        print 'Part2: '.$this->max500Cal;
        print PHP_EOL;
    }
}

$day15 = new Day15();
$day15->main();