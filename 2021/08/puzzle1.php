<?php

$signals = file("input");

// we only care about the outputs for this puzzle;
// and, we only care about those that are 1, 4, 7 and 8
// 1 has two output signals
// 4 has four output signals
// 7 has three output signals
// 8 has seven output signals

$countInstances = 0;

foreach ($signals as $signal) {
    list($patterns, $output) = explode(" | ", trim($signal));

    $outputs = explode(" ", $output);

    foreach ($outputs as $outputSignals) {
        if (strlen($outputSignals) == 2 or
            strlen($outputSignals) == 3 or
            strlen($outputSignals) == 4 or
            strlen($outputSignals) == 7) {
            $countInstances++;
        }

    }
}

echo("There are " . $countInstances . " instances of either 1, 4, 7 or 8 in the output signals\n");