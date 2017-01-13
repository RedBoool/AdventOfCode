# AdventOfCode
My PHP scripts for http://adventofcode.com/

Nice solutions for day 5 [Shell]:
```shell
Part1 : cat input.txt | grep "[aeiou].*[aeiou].*[aeiou]" | grep "\(.\)\1" | egrep -v "(ab|cd|pq|xy)" | wc -l
Part2 : cat input.txt | grep "\(..\).*\1" | grep "\(.\).\1" | wc -l
```

Nice solutions for day 8 [Python]:
```python
Part1 : print sum(len(s[:-1]) - len(eval(s)) for s in open('input.txt'))
Part2 : print sum(2+s.count('\\')+s.count('"') for s in open('input.txt'))
```
