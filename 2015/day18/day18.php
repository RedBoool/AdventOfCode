<?php
class Day18 {
    /**
     * A function to rule them all
     *
     * @param string  $initialConfigFile Input file path
     * @param integer $nbTransformation  How many transform will we perform ?
     * @param boolean $lightStuckOn      Are we computing the first or the second part ?
     */
    public function main($initialConfigFile, $nbTransformation, $lightStuckOn = false) {
        $configuration = $this->loadInitialConfiguration($initialConfigFile);

        if ($lightStuckOn) {
            $configuration = $this->lightStuckOn($configuration);
        }

        // If you want to see what you start with
        // $this->displayConfiguration($configuration);
        // print PHP_EOL;

        for ($i = 0; $i < $nbTransformation; $i++) {
            $configuration = $this->animate($configuration);
            if ($lightStuckOn) {
                $configuration = $this->lightStuckOn($configuration);
            }

            // If you want to see what happen
            // $this->displayConfiguration($configuration);
            // print PHP_EOL;
        }

        if ($lightStuckOn === false) {
            print 'Part1: '.$this->getNumberOfLightOn($configuration);
            print PHP_EOL;
        } else {
            print 'Part2: '.$this->getNumberOfLightOn($configuration);
            print PHP_EOL;
        }
    }

    /**
     * Load config file and split it line by line into an array
     *
     * @param $filePath
     *
     * @return array
     */
    private function loadInitialConfiguration($filePath) {
        $file = file_get_contents($filePath);

        return explode("\n", $file);
    }

    /**
     * Display configuration, for debug purpose
     *
     * @param $configuration
     */
    private function displayConfiguration(array $configuration) {
        foreach ($configuration as $key => $line) {
            print $key.' - '.$line;
            print PHP_EOL;
        }
    }

    /**
     * Goes from one step to another
     *
     * @param array $configuration
     *
     * @return array $newConfig
     */
    private function animate(array $configuration) {
        $newConfig = array();
        foreach ($configuration as $x => $line) {
            $newConfig[$x] = '';
            for ($y = 0; $y < strlen($line); $y++) {
                $newConfig[$x] .= $this->getLightNextState($configuration, $x, $y);
            }
        }

        return $newConfig;
    }

    /**
     * Get the next state for given light
     *
     * @param array $configuration
     * @param $posX
     * @param $posY
     *
     * @return string
     */
    private function getLightNextState(array $configuration, $posX, $posY) {
        $nbSharpFound = 0;
        for ($x = $posX - 1; $x <= $posX + 1; $x++) {
            for ($y = $posY-1; $y <= $posY + 1; $y++) {
                if ($x == $posX && $y == $posY) {
                    continue;
                }

                if (!($x == $posX && $y == $posY) && isset($configuration[$x][$y]) && $configuration[$x][$y] == '#') {
                    $nbSharpFound++;
                }
            }
        }

        if ($configuration[$posX][$posY] === '#' and in_array($nbSharpFound, array(2,3))) {
            $result = '#';
        } else if ($nbSharpFound === 3) {
            $result = '#';
        } else {
            $result = '.';
        }

        return $result;
    }

    /**
     * Count how many lights are on
     *
     * @param array $configuration
     *
     * @return int
     */
    private function getNumberOfLightOn(array $configuration) {
        $nbLightOn = 0;

        foreach ($configuration as $x => $line) {
            for ($y = 0; $y < strlen($line); $y++) {
                if ($configuration[$x][$y] == '#') {
                    $nbLightOn++;
                }
            }
        }

        return $nbLightOn;
    }

    /**
     * For the second part, switch on light that should be stuck on, whatever it's current state
     *
     * @param array $configuration
     *
     * @return array
     */
    private function lightStuckOn(array $configuration) {
        $nbLine = count($configuration);
        $nbColFirstLine = strlen($configuration[0]);
        $nbColLastLine = strlen($configuration[$nbLine - 1]);

        $configuration[0][0] = '#';
        $configuration[0][$nbColFirstLine - 1] = '#';
        $configuration[$nbLine - 1][0] = '#';
        $configuration[$nbLine - 1][$nbColLastLine - 1] = '#';

        return $configuration;
    }
}

$day18 = new Day18();
$day18->main('input.txt', 100);
$day18->main('input.txt', 100, true);