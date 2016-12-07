<?php

$input = 'cxdnnyjw';

$id = 0;

$passwordLetters = [];

while (count($passwordLetters) < 8) {
	$hash = md5($input . $id);

	if (substr($hash, 0, 5) === '00000') {
		$position = substr($hash, 5, 1);
		

		if (is_numeric($position) and ($position >=0 and $position <= 7)) {
			if ( ! isset($passwordLetters[$position])) {
				$passwordLetters[$position] = substr($hash, 6, 1);
			}
		}
	}

	$id++;
}

$password = '';
for ($i = 0; $i < count($passwordLetters); $i++) {
	$password .= $passwordLetters[$i];
}

echo("ID      : " . $id . "\n");
echo("PASSWORD: " . $password . "\n");