<?php

$input = file_get_contents('input');

$input = str_replace("\n", '', $input);

$remain = $input;

$decompressed = '';

while (strlen($remain) > 0) {
	$toRemove = 1;
	$char = $remain[0];

	if ($char == '(') {
		$endLocation = strpos($remain, ')');
		$instruction = substr($remain, 1, $endLocation);
		$toRemove += $endLocation;
		list($length, $repeat) = explode('x', $instruction);
		$toRemove += $length;
		$repeatString = substr($remain, $endLocation+1, $length);
		$decompressed .= str_repeat($repeatString, $repeat);
	} else {
		$decompressed .= $char;
	}

	$remain = substr($remain, $toRemove);
}

echo('LENGTH: ' . strlen($decompressed) . "\n");