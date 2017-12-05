<?php

$input = file('input');

$input = array_map('trim', $input);

$currentPosition = 0;
$outOfBounds = count($input);
$steps = 0;

while (1) {
	$jump = $input[$currentPosition];
	if ($jump >= 3) {
		$input[$currentPosition]--;
	} else {
		$input[$currentPosition]++;
	}
	$currentPosition += $jump;
	$steps++;
	if ($currentPosition >= $outOfBounds || $currentPosition < 0) {
		break;
	}
}

echo("It took " . $steps . " steps to escape\n");