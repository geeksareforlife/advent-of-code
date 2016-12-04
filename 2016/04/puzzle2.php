<?php

$input = file('input2');

foreach ($input as $room) {
	list($name, $sectorId) = explode("\t", $room);

	$realName = decrypt($name, $sectorId);

	echo($realName . "\t" . trim($sectorId) . "\n");
}


function decrypt($ciphertext, $shift) {
	$plaintext = '';

	for ($i = 0; $i < strlen($ciphertext); $i++) {
		if ($ciphertext[$i] == '-') {
			$plaintext .= ' ';
		} else {
			$plaintext .= shiftLetter($ciphertext[$i], $shift);
		}
	}

	return $plaintext;
}

function shiftLetter($letter, $shift) {
	$alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];

	$letter = strtolower($letter);

	$id = array_search($letter, $alphabet);

	$newId = ($id + $shift) % 26;

	return $alphabet[$newId];
}