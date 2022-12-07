<?php

$suffix = '';

$crateInput = file('crates' . $suffix);

$crates = [];

for ($i = count($crateInput)-2; $i >= 0; $i--) {
    $currentCrates = str_split($crateInput[$i], 4);
    for ($j = 0; $j < count($currentCrates); $j++) {
        $crate = trim($currentCrates[$j]);
        if ($crate != '') {
            $crates[$j][] = trim($crate, "[]");
        }
    }
}

$moves = file('input' . $suffix);

foreach ($moves as $move) {
    if (preg_match('/move (?P<number>\d+) from (?P<from>\d+) to (?P<to>\d+)/', $move, $matches)) {
        // get the crates to move
        $movingCrates = array_slice($crates[intval($matches['from'])-1], -intval($matches['number']), intval($matches['number']));
        
        // remove these from the "from" stack
        $leftCrates = array_slice($crates[intval($matches['from'])-1], 0, -intval($matches['number']));
        $crates[intval($matches['from'])-1] = $leftCrates;

        // put the crates on the "to" stack
        $crates[intval($matches['to'])-1] = array_merge($crates[intval($matches['to'])-1], $movingCrates);
    }
}

$signature = '';

foreach ($crates as $crate) {
    $signature .= $crate[count($crate)-1];
}

echo("At the end, the signature is " . $signature . "\n");