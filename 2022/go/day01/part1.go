package main

import (
	"bufio"
	"fmt"
	"os"
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

	var fileLines []int
	var sum = 0
	var max = 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		if 0 == len(strVal) {
			fileLines = append(fileLines, sum)
			if sum > max {
				max = sum
			}
			sum = 0
		}

		intVal, _ := strconv.Atoi(fileScanner.Text())
		sum += intVal
	}

	fmt.Println("Result: ", max)
}
