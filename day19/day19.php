<?php
class Day19 {
    private $transformList = array();

    /**
     * Part 1
     */
    public function part1() {
        $molecule = $this->getInput();

        $allCreatedMolecule = array();
        foreach ($this->transformList as $transform) {
            $createdMolecule = $this->generateNewMolecules($molecule, $transform['from'], $transform['to']);
            $allCreatedMolecule = array_merge($allCreatedMolecule, $createdMolecule);
        }

        print 'Part1: '.count($allCreatedMolecule);
        print PHP_EOL;
    }

    /**
     * Part 2
     * As brute force take too long (many hours), i go see solutions and found this:
     *
     * First insight
     *
     * There are only two types of productions:
     * e => XX and X => XX (X is not Rn, Y, or Ar)
     * X => X Rn X Ar | X Rn X Y X Ar | X Rn X Y X Y X Ar
     * Second insight
     *
     * You can think of Rn Y Ar as the characters ( , ):
     * X => X(X) | X(X,X) | X(X,X,X)
     * Whenever there are two adjacent "elements" in your "molecule", you apply the first production. This reduces your molecule length by 1 each time.
     * And whenever you have T(T) T(T,T) or T(T,T,T) (T is a literal token such as "Mg", i.e. not a nonterminal like "TiTiCaCa"), you apply the second production. This reduces your molecule length by 3, 5, or 7.
     * Third insight
     *
     * Repeatedly applying X => XX until you arrive at a single token takes count(tokens) - 1 steps:
     * ABCDE => XCDE => XDE => XE => X
     * count("ABCDE") = 5
     * 5 - 1 = 4 steps
     * Applying X => X(X) is similar to X => XX, except you get the () for free. This can be expressed as count(tokens) - count("(" or ")") - 1.
     * A(B(C(D(E)))) => A(B(C(X))) => A(B(X)) => A(X) => X
     * count("A(B(C(D(E))))") = 13
     * count("(((())))") = 8
     * 13 - 8 - 1 = 4 steps
     * You can generalize to X => X(X,X) by noting that each , reduces the length by two (,X). The new formula is count(tokens) - count("(" or ")") - 2*count(",") - 1.
     * A(B(C,D),E(F,G)) => A(B(C,D),X) => A(X,X) => X
     * count("A(B(C,D),E(F,G))") = 16
     * count("(()())") = 6
     * count(",,,") = 3
     * 16 - 6 - 2*3 - 1 = 3 steps
     * This final formula works for all of the production types (for X => XX, the (,) counts are zero by definition.)
     * The solution
     *
     * My input file had:
     * 295 elements in total
     *  68 were Rn and Ar (the `(` and `)`)
     *   7 were Y (the `,`)
     * Plugging in the numbers:
     * 295 - 68 - 2*7 - 1 = 212
     */
    public function part2() {
        $molecule = $this->getInput();

        $pattern = '#([A-Z]{1}[a-z]?)#';
        preg_match_all($pattern, $molecule, $match);
        $nbElement = count($match[0]);

        $moleculeElementList = $match[1];
        $variationList = array_unique($match[1]);

        $reject1 = array('Rn', 'Ar');
        $nbReject1 = 0;
        foreach ($moleculeElementList as $moleculeElement) {
            if (in_array($moleculeElement, $reject1)) {
                $nbReject1++;
            }
        }

        $reject2 = array('Y');
        $nbReject2 = 0;
        foreach ($moleculeElementList as $moleculeElement) {
            if (in_array($moleculeElement, $reject2)) {
                $nbReject2++;
            }
        }

        print 'Part2: '.($nbElement - $nbReject1 - 2 * $nbReject2 - 1);
        print PHP_EOL;
    }

    /**
     * Get information from input file. Complete $this->transformList and return molecule
     *
     * @return string $molecule
     */
    private function getInput() {
        $file = file_get_contents('input.txt');
        $lineList = explode("\n", $file);

        $pattern = '#^(\w+) => (\w+)$#';
        for ($i = 0; $i < count($lineList) - 2; $i++) {
            preg_match($pattern, $lineList[$i], $match);

            $this->transformList[$i] = array('from' => $match[1], 'to' => $match[2]);
        }

        return $lineList[count($lineList) - 1];
    }

    /**
     * Create an array with all generated molecules
     *
     * @param string $molecule
     * @param string $from
     * @param string $to
     *
     * @return array
     */
    private function generateNewMolecules($molecule, $from, $to) {
        $strlenFrom = strlen($from);
        $previousPos = -1;
        $createdMolecule = array();
        while (true) {
            $pos = strpos($molecule, $from, $previousPos+1);

            if ($pos === false) {
                break;
            }

            $str = substr($molecule, 0, $pos).$to.substr($molecule, $pos + $strlenFrom);
            $createdMolecule[$str] = true;

            $previousPos = $pos;
        }

        return $createdMolecule;
    }
}

$day19 = new Day19();
$day19->part1();
$day19->part2();
