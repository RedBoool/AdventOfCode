package main

import (
	"bufio"
	"fmt"
	"os"
	"regexp"
	"strconv"
)

func main() {
	filePath := os.Args[1]
	readFile, err := os.Open(filePath)
	if err != nil {
		fmt.Println(err)
	}
	defer readFile.Close()
	fileScanner := bufio.NewScanner(readFile)
	fileScanner.Split(bufio.ScanLines)

	// INIT
	//                 [M]     [W] [M]
	//             [L] [Q] [S] [C] [R]
	//             [Q] [F] [F] [T] [N] [S]
	//     [N]     [V] [V] [H] [L] [J] [D]
	//     [D] [D] [W] [P] [G] [R] [D] [F]
	// [T] [T] [M] [G] [G] [Q] [N] [W] [L]
	// [Z] [H] [F] [J] [D] [Z] [S] [H] [Q]
	// [B] [V] [B] [T] [W] [V] [Z] [Z] [M]
	// 1   2   3   4   5   6   7   8   9
	stack := make([][]string, 9)
	stack[0] = make([]string, 0)
	stack[0] = append(stack[0], `B`, `Z`, `T`)
	stack[1] = make([]string, 0)
	stack[1] = append(stack[1], `V`, `H`, `T`, `D`, `N`)
	stack[2] = make([]string, 0)
	stack[2] = append(stack[2], `B`, `F`, `M`, `D`)
	stack[3] = make([]string, 0)
	stack[3] = append(stack[3], `T`, `J`, `G`, `W`, `V`, `Q`, `L`)
	stack[4] = make([]string, 0)
	stack[4] = append(stack[4], `W`, `D`, `G`, `P`, `V`, `F`, `Q`, `M`)
	stack[5] = make([]string, 0)
	stack[5] = append(stack[5], `V`, `Z`, `Q`, `G`, `H`, `F`, `S`)
	stack[6] = make([]string, 0)
	stack[6] = append(stack[6], `Z`, `S`, `N`, `R`, `L`, `T`, `C`, `W`)
	stack[7] = make([]string, 0)
	stack[7] = append(stack[7], `Z`, `H`, `W`, `D`, `J`, `N`, `R`, `M`)
	stack[8] = make([]string, 0)
	stack[8] = append(stack[8], `M`, `Q`, `L`, `F`, `D`, `S`)

	var active = false
	re := regexp.MustCompile(`move (\d+) from (\d+) to (\d+)`)
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		if strVal == "" {
			active = true
			continue
		}

		if active == true {
			match := re.FindAllStringSubmatch(strVal, -1)
			move, _ := strconv.Atoi(match[0][1])
			from, _ := strconv.Atoi(match[0][2])
			to, _ := strconv.Atoi(match[0][3])

			val := stack[from-1][len(stack[from-1])-move:]
			stack[from-1] = stack[from-1][:len(stack[from-1])-move]
			stack[to-1] = append(stack[to-1], val...)
			// fmt.Println(`val: `, val)
		}
	}

	result := ``
	for _, val := range stack {
		result += val[len(val)-1:][0]
	}

	fmt.Println("Result: ", result)
}
