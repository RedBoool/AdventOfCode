package main

import (
	"bufio"
	"fmt"
	"os"
	"regexp"
	"sort"
	"strconv"
)

type node2 struct {
	isDir   bool
	size    int
	content map[string]node2
}

func main() {
	filePath := os.Args[1]
	readFile, err := os.Open(filePath)
	if err != nil {
		fmt.Println(err)
	}
	defer readFile.Close()
	fileScanner := bufio.NewScanner(readFile)
	fileScanner.Split(bufio.ScanLines)

	root := node2{isDir: true, size: 0, content: make(map[string]node2, 1)}
	currentNode := &root

	nodeStack := make([]*node2, 0)
	nodeStack = append(nodeStack, &root)

	var folderSizeArray []int

	re := regexp.MustCompile(`(?:(\$)\s)?(\w+)(?:\s([\w\.\/]+))?$`)
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		// fmt.Println(strVal)
		match := re.FindAllStringSubmatch(strVal, -1)

		if match[0][1] == `$` {
			if match[0][2] == `ls` {
				continue
			} else if match[0][2] == `cd` {
				if match[0][3] == `..` {
					foldersize := currentNode.size
					nodeStack = nodeStack[:len(nodeStack)-1]
					currentNode = nodeStack[len(nodeStack)-1]
					currentNode.size += foldersize
					folderSizeArray = append(folderSizeArray, foldersize)
				} else if match[0][3] == `/` {
					continue
				} else {
					tmpNode := (*currentNode).content[match[0][3]]
					currentNode = &tmpNode
					nodeStack = append(nodeStack, &tmpNode)
				}
			}
		} else {
			if match[0][2] == `dir` {
				(*currentNode).content[match[0][3]] = node2{size: 0, isDir: true, content: make(map[string]node2)}
			} else {
				filesize, _ := strconv.Atoi(match[0][2])
				currentNode.content[match[0][3]] = node2{size: filesize, isDir: false}
				(*currentNode).size += filesize
			}
		}
	}

	for i := len(nodeStack); i > 1; i-- {
		foldersize := currentNode.size
		nodeStack = nodeStack[:len(nodeStack)-1]
		currentNode = nodeStack[len(nodeStack)-1]
		currentNode.size += foldersize
		folderSizeArray = append(folderSizeArray, foldersize)
	}

	sort.Ints(folderSizeArray)

	result := 0
	for _, val := range folderSizeArray {
		if 40000000 > root.size-val {
			result = val
			break
		}
	}

	fmt.Println("Result: ", result)
}
