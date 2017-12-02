<?php

$input = file('input');

$differences = [];

foreach ($input as $line) {
	$numbers = getNumbers($line);
	$differences[] = max($numbers) - min($numbers);
}

$checksum = 0;

foreach ($differences as $difference) {
	$checksum += $difference;
}

echo("The checksum is " . $checksum . "\n");



function getNumbers($line)
{
	$line = trim($line);

	while (strpos($line, '  ') !== false) {
		$line = str_replace('  ', ' ', $line);
	}

	// deal with mixed whitespace
	$numbers = explode(' ', $line);
	$newNumbers = [];
	foreach ($numbers as $number) {
		$temp = explode("\t", $number);
		$newNumbers = array_merge($newNumbers, $temp);
	}

	return $newNumbers;
}