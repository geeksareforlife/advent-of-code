<?php

$course = file('input');

$horizontal = 0;
$depth = 0;
$aim = 0;

foreach ($course as $instruction) {
    list($direction, $amount) = processInstruction($instruction);

    if ($direction == "forward") {
        $horizontal = $horizontal + $amount;
        $depth = $depth + ($aim * $amount);
    } else if ($direction == "up") {
        $aim = $aim - $amount;
    } else if ($direction == "down") {
        $aim = $aim + $amount;
    }
}

$check = $horizontal * $depth;

echo("At the end, we are " . $horizontal . " units along at a depth of " . $depth . ". Check is " . $check . "\n");

function processInstruction($instruction)
{
    return explode(' ', trim($instruction));
}