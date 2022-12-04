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
	var mapArray = make([]map[uint8]int, 3)
	cpt := 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		idx := cpt % 3
		mapArray[idx] = make(map[uint8]int)

		strLen := len(strVal)
		for i := 0; i < strLen; i++ {

			key := getVal2(strVal[i])
			mapArray[idx][key] = 1
		}

		if idx == 2 {
			result += getUniq2(mapArray)
		}

		cpt++
	}

	fmt.Println("Result: ", result)
}

func getVal2(char uint8) uint8 {
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

func getUniq2(mapArray []map[uint8]int) int {
	for i := range mapArray[0] {
		if _, ok := mapArray[1][i]; ok {
			if _, ok := mapArray[2][i]; ok {
				return int(i)
			}
		}
	}

	return 0
}
