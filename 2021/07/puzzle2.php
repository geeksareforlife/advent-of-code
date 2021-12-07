<?php

$crabList = str_getcsv(file_get_contents("input"));

$fuelGroups = array_count_values($crabList);

$maxPosition = max(array_keys($fuelGroups));

// calculate triangle number lookup
$triangleNumbers = [0];

for ($position = 1; $position <= $maxPosition; $position++) {
    $triangleNumbers[$position] = $triangleNumbers[$position-1] + $position;
}

$minFuel = 1000000000;
$finalPosition = "";

for ($position = 0; $position <= $maxPosition; $position++) {
    $totalFuel = 0;
    foreach ($fuelGroups as $fuel => $count) {
        $neededPerCrab = $triangleNumbers[abs($fuel - $position)];
        $totalFuel = $totalFuel + ($count * $neededPerCrab);
    }

    if ($totalFuel < $minFuel) {
        $minFuel = $totalFuel;
        $finalPosition = $position;
    }
}

echo("They will need " . $minFuel . " fuel to get to position " . $finalPosition . "\n");
