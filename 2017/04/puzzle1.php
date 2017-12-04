<?php

$input = file('input');

$invalid = 0;
$valid = 0;

foreach ($input as $passphrase) {
	if (checkValid($passphrase)) {
		$valid++;
	} else {
		$invalid++;
	}
}

echo("There are " . $valid . " valid passphrases and " . $invalid . " invalid passphrases\n");


function checkValid($passphrase)
{
	$words = explode(' ', $passphrase);
	$seenWords = [];
	
	foreach ($words as $word) {
		$word = trim($word);
		if (in_array($word, $seenWords)) {
			return false;
		} else {
			$seenWords[] = $word;
		}
	}

	return true;
}
