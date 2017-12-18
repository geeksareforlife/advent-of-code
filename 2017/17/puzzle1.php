<?php

$input = file_get_contents('input');

$steps = intval(trim($input));

$buffer = [0];
$currentPosition = 0;

for ($i = 1; $i < 2018; $i++) {
	$insertPosition = ($currentPosition + $steps) % count($buffer) + 1;

	$start = array_slice($buffer, 0, $insertPosition);


	if (count($buffer) > $insertPosition) {
		$end = array_slice($buffer, $insertPosition);
	} else {
		$end = [];
	}

	$buffer = array_merge($start, [$i], $end);
	$currentPosition = $insertPosition;
}

echo("The value after 2017 is " . $buffer[$currentPosition + 1] . "\n");