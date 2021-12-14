<?php

$test = false;

if ($test) {
    $input = file("input.test");
    $template = str_split("NNCB");
} else {
    $input = file("input");
    $template = str_split("CNBPHFBOPCSPKOFNHVKV");
}

// first let's sort out our pair insertion
$pairInsert = [];

foreach ($input as $line) {
    list($pair, $insert) = explode(" -> ", trim($line));
    $pairInsert[$pair] = $insert;
}

// we are going to keep track of counts of pairs this time
$pairs = [];

for ($i = 0; $i < (count($template) - 1); $i++) {
    if (!isset($pairs[$template[$i] . $template[$i+1]])) {
        $pairs[$template[$i] . $template[$i+1]] = 0;
    }
    $pairs[$template[$i] . $template[$i+1]]++;
}

$steps = 40;

// now, we check what would happen to each pair
for ($step = 0; $step < $steps; $step++) {
    foreach ($pairs as $pair => $count) {
        if (!isset($pairs[$pair[0] . $pairInsert[$pair]])) {
            $pairs[$pair[0] . $pairInsert[$pair]] = 0;
        }
        $pairs[$pair[0] . $pairInsert[$pair]] += $count;

        if (!isset($pairs[$pairInsert[$pair] . $pair[1]])) {
            $pairs[$pairInsert[$pair] . $pair[1]] = 0;
        }
        $pairs[$pairInsert[$pair] . $pair[1]] += $count;

        $pairs[$pair] -= $count;
    }
}

// now get the counts of the elements
// at the moment, we are double counting everything except first and last characters
$elements = [];

foreach ($pairs as $pair => $count) {
    if ($count == 0) {
        continue;
    }

    if (!isset($elements[$pair[0]])) {
        $elements[$pair[0]] = 0;
    }
    $elements[$pair[0]] += $count;

    if (!isset($elements[$pair[1]])) {
        $elements[$pair[1]] = 0;
    }
    $elements[$pair[1]] += $count;    
}
// also, we need to count the first and last characters again
$elements[$template[0]]++;
$elements[$template[count($template)-1]]++;

$difference = (max($elements) / 2) - (min($elements) / 2);

echo("The difference is " . $difference . "\n");