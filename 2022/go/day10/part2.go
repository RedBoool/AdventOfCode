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

    array := make([]string, 10)
    cycle := 0
    x := 1
    re := regexp.MustCompile(`^addx ([\d\-]+)$`)
    for fileScanner.Scan() {
        strVal := fileScanner.Text()

        if strVal == `noop` {
            if cycle % 40 - x <= 1 && cycle % 40 - x >= -1 {
                array[cycle/40] += `#`
            } else {
                array[cycle/40] += `.`
            }
            cycle++
            continue
        }

        match := re.FindAllStringSubmatch(strVal, -1)
        val, _ := strconv.Atoi(match[0][1])

        if cycle % 40 - x <= 1 && cycle % 40 - x >= -1 {
            array[cycle/40] += `#`
        } else {
            array[cycle/40] += `.`
        }
        cycle++

        if cycle % 40 - x <= 1 && cycle % 40 - x >= -1 {
            array[cycle/40] += `#`
        } else {
            array[cycle/40] += `.`
        }
        cycle++
        x += val
    }

    fmt.Println(`Result:`)
    for i:=0;i<6;i++ {
        fmt.Println(array[i])
    }
}
