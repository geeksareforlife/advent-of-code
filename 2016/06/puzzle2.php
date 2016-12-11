<?php

$input = file('input');

$message = [];

foreach ($input as $line) {
	$line = trim($line);

	for ($i = 0; $i < strlen($line); $i++) {
		$letter = $line[$i];

		if ( ! isset($message[$i])) {
			$message[$i] = [];
		}

		if ( ! isset($message[$i][$letter])) {
			$message[$i][$letter] = 0;
		}

		$message[$i][$letter]++;
	}
}

$corrected = '';

foreach ($message as $possibleLetter) {
	asort($possibleLetter);
	
	$keys = array_keys($possibleLetter);

	$corrected .= array_shift($keys);
}

echo("MESSAGE: " . $corrected . "\n");