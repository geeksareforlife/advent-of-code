<?php

$input = file('input');

$total = 0;

foreach ($input as $rucksack) {
    $rucksack = trim($rucksack);

    $length = strlen($rucksack) / 2;

    $compartments = array_chunk(str_split($rucksack), $length);

    foreach ($compartments[0] as $item) {
        if (in_array($item, $compartments[1])) {
            $total += getPriority($item);
            break;
        }
    }
}

echo("The sum of the priorities is " . $total . "\n");


function getPriority($char)
{
    $number = ord($char);

    if ($number > 96) {
        return $number - 96; // lowercase
    } else {
        return $number - 64 + 26;
    }
}