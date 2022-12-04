package main

import (
	"bufio"
	"fmt"
	"os"
	"strconv"
	"strings"
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

	result := 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		positions := make([][]int, 2)

		pairs := strings.Split(strVal, `,`)
		for idx, pair := range pairs {
			pos := strings.Split(pair, `-`)

			positions[idx] = make([]int, 2)

			val, _ := strconv.Atoi(pos[0])
			positions[idx][0] = val
			val, _ = strconv.Atoi(pos[1])
			positions[idx][1] = val
		}

		if positions[0][0] >= positions[1][0] && positions[0][1] <= positions[1][1] {
			result += 1
		} else if positions[1][0] >= positions[0][0] && positions[1][1] <= positions[0][1] {
			result += 1
		} else if positions[0][1] >= positions[1][0] && positions[0][0] <= positions[1][1] {
			result += 1
		} else if positions[1][1] >= positions[0][0] && positions[1][1] <= positions[0][0] {
			result += 1
		}
	}

	fmt.Println("Result: ", result)
}
