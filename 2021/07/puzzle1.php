<?php

$crabList = str_getcsv(file_get_contents("input"));

$fuelGroups = array_count_values($crabList);

$positions = array_keys($fuelGroups);

$minFuel = 10000000;
$finalPosition = "";

foreach ($positions as $position) {
    $totalFuel = 0;
    foreach ($fuelGroups as $fuel => $count) {
        $neededPerCrab = abs($fuel - $position);
        $totalFuel = $totalFuel + ($count * $neededPerCrab);
    }

    if ($totalFuel < $minFuel) {
        $minFuel = $totalFuel;
        $finalPosition = $position;
    }
}

echo("They will need " . $minFuel . " fuel to get to position " . $finalPosition . "\n");