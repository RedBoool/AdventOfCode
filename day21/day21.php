<?php
/**
 * Give the winner of a winner
 *
 * @param array $player
 * @param array $boss
 *
 * @return string $winner The winner of the fight, "player" or "boss"
 */
function fight(array $player, array $boss) {
    while (true) {
        $hit = $player['damage'] - $boss['armor'];
        $boss['life'] -= $hit > 1 ? $hit : 1;
        if ($boss['life'] <= 0) {
            return 'player';
        }

        $hit = $boss['damage'] - $player['armor'];
        $player['life'] -= $hit > 1 ? $hit : 1;
        if ($player['life'] <= 0) {
            return 'boss';
        }
    }
}

$weaponList = array(
    // Available weapons in the store
    array('name' => 'Dagger',      'cost' => 8,   'damage' => 4, 'armor' => 0),
    array('name' => 'Shortsword',  'cost' => 10,  'damage' => 5, 'armor' => 0),
    array('name' => 'Warhammer',   'cost' => 25,  'damage' => 6, 'armor' => 0),
    array('name' => 'Longsword',   'cost' => 40,  'damage' => 7, 'armor' => 0),
    array('name' => 'Greataxe',    'cost' => 74,  'damage' => 8, 'armor' => 0),
);

$armorList = array(
    // Add by me to simulate no armor
    array('name' => 'No armor', 'cost' => 0, 'damage' => 0, 'armor' => 0),
    // Available armor in the store
    array('name' => 'Leather',     'cost' => 13,  'damage' => 0, 'armor' => 1),
    array('name' => 'Chainmail',   'cost' => 31,  'damage' => 0, 'armor' => 2),
    array('name' => 'Splintmail',  'cost' => 53,  'damage' => 0, 'armor' => 3),
    array('name' => 'Bandedmail',  'cost' => 75,  'damage' => 0, 'armor' => 4),
    array('name' => 'Platemail',   'cost' => 102, 'damage' => 0, 'armor' => 5),

);

$ringList = array(
    // Add by me to simulate no ring
    array ('name' => 'No Damage',  'cost' => 0,   'damage' => 0, 'armor' => 0),
    array ('name' => 'No Defense', 'cost' => 0,   'damage' => 0, 'armor' => 0),
    // Available rings in the store
    array ('name' => 'Damage +1',  'cost' => 25,  'damage' => 1, 'armor' => 0),
    array ('name' => 'Damage +2',  'cost' => 50,  'damage' => 2, 'armor' => 0),
    array ('name' => 'Damage +3',  'cost' => 100, 'damage' => 3, 'armor' => 0),
    array ('name' => 'Defense +1', 'cost' => 20,  'damage' => 0, 'armor' => 1),
    array ('name' => 'Defense +2', 'cost' => 40,  'damage' => 0, 'armor' => 2),
    array ('name' => 'Defense +3', 'cost' => 80,  'damage' => 0, 'armor' => 3),

);

$player = array(
    'life' => 100,
    'damage' => 0,
    'armor' => 0,
);
// Parameter copied from the input
$boss = array(
    'life' => 100,
    'damage' => 8,
    'armor' => 2,
);

$minCost = 10000;
$maxCost = 0;
foreach ($weaponList as $weapon) {
    foreach ($armorList as $armor) {
        $secondRingList = $ringList;
        foreach ($ringList as $key => $firstRing) {
            unset($secondRingList[$key]);
            if (!empty($secondRingList)) {
                foreach ($secondRingList as $secondRing) {
                    $cost = $weapon['cost'] + $armor['cost'] + $firstRing['cost'] + $secondRing['cost'];

                    if ($cost > $minCost && $cost < $maxCost) {
                        continue;
                    }

                    $currentPlayer = $player;
                    $currentPlayer['damage'] += $weapon['damage'] + $firstRing['damage'] + $secondRing['damage'];
                    $currentPlayer['armor'] += $armor['armor'] + $firstRing['armor'] + $secondRing['armor'];

                    $fightWinner = fight($currentPlayer, $boss);
                    if ($fightWinner === 'player') {
                        $minCost = min($minCost, $cost);
                    } else {
                        $maxCost = max($maxCost, $cost);
                    }

                }
            }
        }
    }
}

print 'Part1: '.$minCost;
print PHP_EOL;
print 'Part2: '.$maxCost;
print PHP_EOL;
