<?php

// first, store input in a grid.  As always, y is 1st dimension, x is 2nd

$lines = file("input");

$octopuses = [];

foreach ($lines as $line) {
    $octopuses[] = str_split(trim($line));
}

echo("Step 0\n");
displayOctopuses($octopuses);

$steps = 100;
$flashes = 0;

for ($step = 0; $step < $steps; $step++) {
    // first increment every octopus
    array_walk_recursive($octopuses, 'increment');
    
    // have we got any flashers?
    $flashers = findFlashers($octopuses);

    while (count($flashers) > 0) {
        $flashes = $flashes + count($flashers);
        foreach ($flashers as $flasher) {
            $octopuses = flash($flasher, $octopuses);
        }

        array_walk_recursive($octopuses, 'setZero');

        $flashers = findFlashers($octopuses);
    }

    if ($step%10 == 9) {
        echo("Step " . ($step+1) . "\n");
        displayOctopuses($octopuses);
    }
}

echo("After " . ($step+1) . " steps, there were " . $flashes . " flashes\n");

function increment(&$item, $key)
{
    $item++;
}

function setZero(&$item, $key)
{
    if ($item == "-") {
        $item = 0;
    }
}

function displayOctopuses($octopuses)
{
    foreach ($octopuses as $line) {
        echo(implode(" ", $line) . "\n");
    }
}

function findFlashers($octopuses)
{
    $flashers = [];

    $maxY = count($octopuses);
    $maxX = count($octopuses[0]);

    for ($y = 0; $y < $maxY; $y++) {
        for ($x = 0; $x < $maxX; $x++) {
            if ($octopuses[$y][$x] > 9) {
                $flashers[] = ['x' => $x, 'y' => $y];
            }
        }
    }

    return $flashers;
}

function flash($flasher, $octopuses)
{
    $maxY = count($octopuses) - 1;
    $maxX = count($octopuses[0]) - 1;

    $octopuses[$flasher['y']][$flasher['x']] = '-';

    // the square we want to increment
    $left = $flasher['x'] == 0 ? 0 :$flasher['x'] - 1;
    $right = $flasher['x'] == $maxX ? $maxX : $flasher['x'] + 1;
    $bottom = $flasher['y'] == 0 ? 0 : $flasher['y'] - 1;
    $top = $flasher['y'] == $maxY ? $maxY : $flasher['y'] + 1;

    for ($y = $bottom; $y <= $top; $y++) {
        for ($x = $left; $x <= $right; $x++) {
            if ($octopuses[$y][$x] == "-") {
                // flashed this step, ignore
            } else {
                $octopuses[$y][$x] = $octopuses[$y][$x] + 1;
            }
        }
    }

    return $octopuses;
}