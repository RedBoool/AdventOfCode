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

	array := make([]int, 10)
	cycle := 0
	x := 1
	re := regexp.MustCompile(`^addx ([\d\-]+)$`)
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		array[(cycle+20)/40] = (((cycle+20)/40) * 40 + 20) * x

		if strVal == `noop` {
			cycle++
			continue
		}

		match := re.FindAllStringSubmatch(strVal, -1)
		val, _ := strconv.Atoi(match[0][1])
		cycle += 2
		x += val
	}

	result := 0
	for i:=0;i<6;i++ {
		result += array[i]
	}

	fmt.Println("Result: ", result)
}
