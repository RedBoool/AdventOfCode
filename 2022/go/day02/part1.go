package main

import (
	"bufio"
	"fmt"
	"os"
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

	var score = 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()
		split := strings.Split(strVal, " ")

		tmp := (strVal[0] - strVal[2]) % 3

		// Win
		if tmp == 0 { // 0 => Draw
			score += 0
		} else if tmp == 1 { // 1 => Win
			score += 6
		} else { // 2 => Lose
			score += 3
		}

		// Choice
		if split[1] == `X` { // Rock
			score += 1
		} else if split[1] == `Y` { // Paper
			score += 2
		} else { // Scissors
			score += 3
		}
	}

	fmt.Println(`Result: `, score)
}
