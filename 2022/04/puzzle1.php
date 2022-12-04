<?php

$input = file("input");

$overlapCount = 0;

foreach ($input as $pair) {
    $elves = explode(',', trim($pair));
    
    if(contained($elves)) {
        $overlapCount++;
    }
}

echo($overlapCount . " pairs are overlapping completely\n");


function contained($elves)
{
    $expanded = [];

    $largest = 0;
    $largestID = 0;
    for ($i = 0; $i < count($elves); $i++) {
        $range = expand($elves[$i]);
        if (count($range) > $largest) {
            $largestID = $i;
            $largest = count($range);
        }
        $expanded[] = $range;
    }

    $smallestID = 0;
    if ($largestID == 0) {
        $smallestID = 1;
    }

    return contains($expanded[$largestID], $expanded[$smallestID]);

}

function contains($largeRange, $smallRange)
{
    foreach ($smallRange as $number) {
        if (!in_array($number, $largeRange)) {
            return false;
        }
    }

    return true;
}

function expand($range) {
    list($start, $finish) = explode('-', $range);
    $expanded = [];
    for ($i = intval($start); $i <= intval($finish); $i++) {
        $expanded[] = $i;
    }
    return $expanded;
}