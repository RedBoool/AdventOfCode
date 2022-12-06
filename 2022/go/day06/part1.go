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

	j := 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		packet := make([]uint8, 4)
		for j = 0; j < len(strVal); j++ {
			packet[j%4] = strVal[j]
			if j < 4 {
				continue
			}

			uniqSlice := unique(packet)

			if len(uniqSlice) == 4 {
				break
			}
		}

		break
	}

	fmt.Println("Result: ", j+1)
}

func unique(input []uint8) []uint8 {
	u := make([]uint8, 0, len(input))
	m := make(map[uint8]bool)

	for _, val := range input {
		if _, ok := m[val]; !ok {
			m[val] = true
			u = append(u, val)
		}
	}

	return u
}
