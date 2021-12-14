<?php

// a naughty helper
$input = file("input");
$maxX = 0;
$maxY = 0;

foreach ($input as $line) {
    if (trim($line) == "") {
        break;
    } else {
        list($x,$y) = explode(",", trim($line));
        if ($x > $maxX) {
            $maxX = $x;
        }
        if ($y > $maxY) {
            $maxY = $y;
        }
    }
}

echo("Max X is " . $maxX . " and max Y is " . $maxY . "\n");