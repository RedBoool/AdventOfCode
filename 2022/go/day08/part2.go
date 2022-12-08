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

	var field = make([][]int, 0)
	var visible = make([][]bool, 0)
	lineNumber := 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		field = append(field, make([]int, len(strVal)))
		visible = append(visible, make([]bool, len(strVal)))

		for i := 0; i < len(strVal); i++ {
			treeSize, _ := strconv.Atoi(string(strVal[i]))
			field[lineNumber][i] = treeSize
		}

		lineNumber++
	}

	maxResult := 0
	for x := 1; x < len(field)-1; x++ {
		for y := 1; y < len(field[x])-1; y++ {
			// UP
			cpt1 := 0
			for i := x - 1; i >= 0; i-- {
				cpt1++
				if field[x][y] <= field[i][y] {
					break
				}
			}

			// DOWN
			cpt2 := 0
			for i := x + 1; i < len(field[x]); i++ {
				cpt2++
				if field[x][y] <= field[i][y] {
					break
				}
			}

			// LEFT
			cpt3 := 0
			for i := y - 1; i >= 0; i-- {
				cpt3++
				if field[x][y] <= field[x][i] {
					break
				}
			}

			// LEFT
			cpt4 := 0
			for i := y + 1; i < len(field); i++ {
				cpt4++
				if field[x][y] <= field[x][i] {
					break
				}
			}

			result := cpt1 * cpt2 * cpt3 * cpt4
			if result > maxResult {
				maxResult = result
			}
		}
	}

	fmt.Println("Result: ", maxResult)
}
