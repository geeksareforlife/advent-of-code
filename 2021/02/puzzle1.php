<?php

$course = file('input');

$horizontal = 0;
$depth = 0;

foreach ($course as $instruction) {
    list($direction, $amount) = processInstruction($instruction);

    if ($direction == "forward") {
        $horizontal = $horizontal + $amount;
    } else if ($direction == "up") {
        $depth = $depth - $amount;
    } else if ($direction == "down") {
        $depth = $depth + $amount;
    }
}

$check = $horizontal * $depth;

echo("At the end, we are " . $horizontal . " units along at a depth of " . $depth . ". Check is " . $check . "\n");

function processInstruction($instruction)
{
    return explode(' ', trim($instruction));
}