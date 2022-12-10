package main

import (
	"bufio"
	"fmt"
	"os"
	"regexp"
	"sort"
	"strconv"
	"strings"
)

type monkey struct {
	items []int
	operation int
	operand string
	divisible int
	throwTrue int
	throwFalse int
	activity int
}

func main() {
	filePath := os.Args[1]
	readFile, err := os.Open(filePath)
	if err != nil {
		fmt.Println(err)
	}
	defer readFile.Close()
	fileScanner := bufio.NewScanner(readFile)
	fileScanner.Split(bufio.ScanLines)

	var current monkey
	lineCpt := 0
	monkeys := make([]monkey, 0)
	reItems := regexp.MustCompile(`^\s+Starting items: ([\d\s,]+)$`)
	reOperation := regexp.MustCompile(`^\s+Operation: new = old ([\+\*]+) (\w+)$`)
	reDivisible := regexp.MustCompile(`^\s+Test: divisible by (\d+)$`)
	reTrue := regexp.MustCompile(`^\s+If true: throw to monkey (\d+)$`)
	reFalse := regexp.MustCompile(`^\s+If false: throw to monkey (\d+)$`)
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		if (lineCpt % 7 == 0) {
			current = monkey{activity: 0}
		} else if (lineCpt % 7 == 1) {
			match := reItems.FindAllStringSubmatch(strVal, -1)
			itemList := strings.Split(match[0][1], `, `)
			items := make([]int, 0)
			for _, val := range itemList {
				item, _ := strconv.Atoi(val)
				items = append(items, item)
			}
			current.items = items
		} else if (lineCpt % 7 == 2) {
			match := reOperation.FindAllStringSubmatch(strVal, -1)
			if match[0][2] == `old` {
				current.operation = 0
			} else {
				val, _ := strconv.Atoi(match[0][2])
				current.operation = val
			}
			current.operand = match[0][1]
		} else if (lineCpt % 7 == 3) {
			match := reDivisible.FindAllStringSubmatch(strVal, -1)
			val, _ := strconv.Atoi(match[0][1])
			current.divisible = val
		} else if (lineCpt % 7 == 4) {
			match := reTrue.FindAllStringSubmatch(strVal, -1)
			val, _ := strconv.Atoi(match[0][1])
			current.throwTrue = val
		} else if (lineCpt % 7 == 5) {
			match := reFalse.FindAllStringSubmatch(strVal, -1)
			val, _ := strconv.Atoi(match[0][1])
			current.throwFalse = val
		} else if (lineCpt % 7 == 6) {
			monkeys = append(monkeys, current)
		}
		lineCpt++
	}
	monkeys = append(monkeys, current)

	for i := 0; i < 20; i++ {
		for idx, monkey := range monkeys {
			for _, item := range monkey.items {
				monkeys[idx].activity++
				worry := 0
				if monkey.operand == `*` {
					if monkey.operation == 0 {
						worry = item * item
					} else {
						worry = item * monkey.operation
					}
				} else {
					worry = item + monkey.operation
				}

				newWorry := worry / 3

				if (newWorry % monkey.divisible == 0) {
					monkeys[monkey.throwTrue].items = append(monkeys[monkey.throwTrue].items, newWorry)
				} else {
					monkeys[monkey.throwFalse].items = append(monkeys[monkey.throwFalse].items, newWorry)
				}
			}
			monkeys[idx].items = make([]int, 0)
		}
	}

	activities := make([]int, 0)
	for _, monkey := range monkeys {
		activities = append(activities, monkey.activity)
	}
	sort.Ints(activities)

	result := 1
	for _, val := range activities[len(activities)-2:] {
		result *= val
	}

	fmt.Println("Result: ", result)
}
