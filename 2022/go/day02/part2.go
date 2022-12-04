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

		// Win
		if split[1] == `X` { // X => Lose
			score += 0
		} else if split[1] == `Y` { // Y => Draw
			score += 3
		} else { // Z => Win
			score += 6
		}

		var willPlay = strVal[2]
		if split[0] == `A` { // X => Lose
			if split[1] == `X` {
				willPlay += 2
			} else {
				willPlay -= 1
			}
		} else if split[0] == `C` { // Y => Draw
			if split[1] == `Z` {
				willPlay -= 2
			} else {
				willPlay += 1
			}
		}

		// Choice
		if string(willPlay) == `X` { // Rock
			score += 1
		} else if string(willPlay) == `Y` { // Paper
			score += 2
		} else { // Scissors
			score += 3
		}
	}

	fmt.Println(`Result: `, score)
}
