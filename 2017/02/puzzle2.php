<?php

$input = file('input');

$results = [];

foreach ($input as $line) {
	$numbers = getNumbers($line);
	$results[] = getResult($numbers);
}

$checksum = 0;

foreach ($results as $result) {
	$checksum += $result;
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

function getResult($numbers)
{
	for ($i = 0; $i < count($numbers); $i++) {
		for ($j = $i+1; $j < count($numbers); $j++) {
			if ($numbers[$i] % $numbers[$j] === 0) {
				return $numbers[$i] / $numbers[$j];
			} elseif ($numbers[$j] % $numbers[$i] === 0) {
				return $numbers[$j] / $numbers[$i];
			}
		}
	}

	// nothing is divisible!
	return 0;
}