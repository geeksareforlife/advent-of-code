<?php

$readings = file('input');

// first, split into measurement windows
$windows = [];

for ($i = 0; $i < count($readings); $i++) {
    if ($i + 2 >= count($readings)) {
        // not enough readings left;
        break;
    }

    $windows[] = getNum($readings[$i]) + getNum($readings[$i+1]) + getNum($readings[$i+2]);
}

$previous = "";
$numIncreases = 0;
foreach ($windows as $reading) {
    if ($previous !== "" and $reading > $previous) {
        $numIncreases++;
    }

    $previous = $reading;
}

echo("The reading increased " . $numIncreases . " times\n");

function getNum($reading) {
    return trim(intval($reading));
}