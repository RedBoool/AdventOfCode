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

	// FROM LEFT
	for i := 0; i < len(field); i++ {
		maxLine := -1
		for j := 0; j < len(field); j++ {
			if field[i][j] > maxLine {
				maxLine = field[i][j]
				visible[i][j] = true
			}
		}
	}
	// FROM RIGHT
	for i := 0; i < len(field); i++ {
		maxLine := -1
		for j := len(field) - 1; j >= 0; j-- {
			if field[i][j] > maxLine {
				maxLine = field[i][j]
				visible[i][j] = true
			}
		}
	}
	// FROM TOP
	for j := len(field) - 1; j >= 0; j-- {
		maxLine := -1
		for i := 0; i < len(field); i++ {
			if field[i][j] > maxLine {
				maxLine = field[i][j]
				visible[i][j] = true
			}
		}
	}
	// FROM BOTTOM
	for j := len(field) - 1; j >= 0; j-- {
		maxLine := -1
		for i := len(field) - 1; i >= 0; i-- {
			if field[i][j] > maxLine {
				maxLine = field[i][j]
				visible[i][j] = true
			}
		}
	}

	count := 0
	for j := len(field) - 1; j >= 0; j-- {
		for i := len(field) - 1; i >= 0; i-- {
			if visible[i][j] {
				count += 1
			}
		}
	}

	fmt.Println("Result: ", count)
}
