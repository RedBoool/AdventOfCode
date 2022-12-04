package main

import (
	"bufio"
	"fmt"
	"os"
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

	var result = 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		start := make(map[uint8]int)
		end := make(map[uint8]int)
		strLen := len(strVal)
		for i := 0; i < strLen/2; i++ {
			startKey := getVal(strVal[i])
			start[startKey] = 1

			endKey := getVal(strVal[strLen-i-1])
			end[endKey] = 1
		}

		result += getUniq(start, end)
	}

	fmt.Println("Result: ", result)
}

func getVal(char uint8) uint8 {
	// Ascii code
	// a: 97
	// z: 122
	// A: 65
	// Z: 90
	if char > 95 {
		return char - 96
	} else {
		return char - 38
	}
}

func getUniq(map1 map[uint8]int, map2 map[uint8]int) int {
	for i := range map1 {
		if _, ok := map2[i]; ok {
			return int(i)
		}
	}

	return 0
}
