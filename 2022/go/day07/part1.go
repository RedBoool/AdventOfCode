package main

import (
	"bufio"
	"fmt"
	"os"
	"regexp"
	"strconv"
)

type node struct {
	isDir   bool
	size    int
	content map[string]node
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

	root := node{isDir: true, size: 0, content: make(map[string]node, 1)}
	currentNode := &root

	nodeStack := make([]*node, 0)
	nodeStack = append(nodeStack, &root)

	re := regexp.MustCompile(`(?:(\$)\s)?(\w+)(?:\s([\w\.\/]+))?$`)
	total := 0
	for fileScanner.Scan() {
		strVal := fileScanner.Text()

		// fmt.Println(strVal)
		match := re.FindAllStringSubmatch(strVal, -1)

		if match[0][1] == `$` {
			if match[0][2] == `ls` {
				continue
			} else if match[0][2] == `cd` {
				if match[0][3] == `..` {
					folderSize := currentNode.size
					nodeStack = nodeStack[:len(nodeStack)-1]
					currentNode = nodeStack[len(nodeStack)-1]
					currentNode.size += folderSize
					if folderSize < 100000 {
						total += folderSize
					}
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
				(*currentNode).content[match[0][3]] = node{size: 0, isDir: true, content: make(map[string]node)}
			} else {
				filesize, _ := strconv.Atoi(match[0][2])
				currentNode.content[match[0][3]] = node{size: filesize, isDir: false}
				(*currentNode).size += filesize
			}
		}
	}

	for i := len(nodeStack); i > 1; i-- {
		folderSize := currentNode.size
		nodeStack = nodeStack[:len(nodeStack)-1]
		currentNode = nodeStack[len(nodeStack)-1]
		currentNode.size += folderSize
		if folderSize < 100000 {
			total += folderSize
		}
	}

	fmt.Println("Result: ", total)
}
