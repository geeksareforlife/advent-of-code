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
			foreach (getAnagrams($word) as $anagram) {
				if (in_array($anagram, $seenWords)) {
					return false;
				}
			}
			$seenWords[] = $word;
		}
	}

	return true;
}

function getAnagrams($word)
{
	if (strlen($word) == 2) {
		return [
			$word,
			$word[1] . $word[0]
		];
	} else {
		$anagrams = [];

		for ($i = 0; $i < strlen($word); $i++) {
			$first = $word[$i];
			$remaining = '';
			for ($j = 0; $j < strlen($word); $j++) {
				if ($j !== $i) {
					$remaining .= $word[$j];
				}
			}
			$newAnagrams = getAnagrams($remaining);
			foreach ($newAnagrams as $anagram) {
				$anagrams[] = $first . $anagram;
			}
		}

		return $anagrams;
	}
}
