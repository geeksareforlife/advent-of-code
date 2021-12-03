<?php

$readings = file('input');

$previous = "";
$numIncreases = 0;

foreach ($readings as $reading) {
    $reading = trim(intval($reading));
    if ($previous !== "" and $reading > $previous) {
        $numIncreases++;
    }

    $previous = $reading;
}

echo("The reading increased " . $numIncreases . " times\n");