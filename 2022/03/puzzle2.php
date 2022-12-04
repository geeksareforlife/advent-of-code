<?php

$input = file('input');

$total = 0;

for ($i = 0; $i < count($input); $i = $i + 3) {
    $rucksack1 = str_split(trim($input[$i]));
    $rucksack2 = str_split(trim($input[$i + 1]));
    $rucksack3 = str_split(trim($input[$i + 2]));

    foreach ($rucksack1 as $item) {
        if (in_array($item, $rucksack2)) {
            if(in_array($item, $rucksack3)) {
                $total += getPriority($item);
                break;
            }
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
