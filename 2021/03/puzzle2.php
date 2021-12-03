<?php

$numbers = trimNumbers(file('input'));

$o2Bytes = $numbers;
$co2Bytes = $numbers;

// all numbers are the same length
$numLength = strlen($numbers[0]);

$o2Rating = "";
$co2Rating = "";

$bitID = 0;
while ($o2Rating == "") {
    $bitCount = getBitCount($o2Bytes, $bitID);
    if ($bitCount[0] > $bitCount[1]) {
        $value = 0;
    } else if ($bitCount[0] < $bitCount[1]) {
        $value = 1;
    } else {
        $value = 1;
    }
    $o2Bytes = filterNumbers($o2Bytes, $bitID, $value);

    if (count($o2Bytes) > 1) {
        $bitID++;
        if ($bitID >= $numLength) {
            echo("error, no more buits (o2Rating)\n").
            die;
        }
    } else {
        $o2Rating = $o2Bytes[0];
    }
}

$bitID = 0;
while ($co2Rating == "") {
    $bitCount = getBitCount($co2Bytes, $bitID);
    if ($bitCount[0] > $bitCount[1]) {
        $value = 1;
    } else if ($bitCount[0] < $bitCount[1]) {
        $value = 0;
    } else {
        $value = 0;
    }
    $co2Bytes = filterNumbers($co2Bytes, $bitID, $value);

    if (count($co2Bytes) > 1) {
        $bitID++;
        if ($bitID >= $numLength) {
            echo("error, no more buits (co2Rating)\n").
            die;
        }
    } else {
        $co2Rating = $co2Bytes[0];
    }
}

$lsRating = bindec($o2Rating) * bindec($co2Rating);

echo("O2 Rating is " . $o2Rating . " (" . bindec($o2Rating) . "), CO2 Rating is " . $co2Rating . " (" . bindec($co2Rating) . ") making life support rating " . $lsRating . "\n");


function trimNumbers($numbers) {
    $trimmed = [];
    foreach ($numbers as $number) {
        $trimmed[] = trim($number);
    }
    return $trimmed;
}

function getBitCount($numbers, $bitID)
{
    $bitCount = ["0" => 0, "1" => 0];

    foreach ($numbers as $number) {
        $bitCount[$number[$bitID]]++;
    }

    return $bitCount;
}

function filterNumbers($numbers, $bitID, $filter) {
    $filtered = [];

    foreach ($numbers as $number) {
        if ($number[$bitID] == $filter) {
            $filtered[] = $number;
        }
    }

    return $filtered;
}