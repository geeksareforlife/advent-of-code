<?php

//483

$input = file_get_contents('input');

$steps = intval(trim($input));

$bufferSize = 1;
$currentPosition = 0;

$afterZero = 0;


for ($i = 1; $i < 50000001; $i++) {
	$insertPosition = ($currentPosition + $steps) % $bufferSize + 1;

	if ($insertPosition === 1) {
		$afterZero = $i;
	}

	$currentPosition = $insertPosition;
	$bufferSize++;
}

echo("The value after 0 is " . $afterZero . "\n");