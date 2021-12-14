<?php

$test = false;

if ($test) {
    $input = file("input.test");
    $template = "NNCB";
} else {
    $input = file("input");
    $template = "CNBPHFBOPCSPKOFNHVKV";
}

// first let's sort out our pair insertion
$pairInsert = [];

foreach ($input as $line) {
    list($pair, $insert) = explode(" -> ", trim($line));
    $pairInsert[$pair] = $insert;
}

$steps = 10;

$polymer = $template;
for ($step = 0; $step < $steps; $step++) {
    $newPolymer = "";

    for ($i = 0; $i < (strlen($polymer) - 1); $i++) {
        $pair = $polymer[$i] . $polymer[$i+1];

        $newPolymer .= $polymer[$i] . $pairInsert[$pair];
    }

    // add the last one on
    $newPolymer .= $polymer[$i];


    $polymer = $newPolymer;
}

// now we need to find the element counts
$elementCounts = array_count_values(str_split($polymer));

$difference = max($elementCounts) - min($elementCounts);

echo("The difference is " . $difference . "\n");