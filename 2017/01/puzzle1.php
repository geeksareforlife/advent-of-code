<?php

$input = trim(file_get_contents('input'));

$sum = 0;

$length = strlen($input);

for ($i = 0; $i < $length; $i++) {
	$next = $i + 1 == $length ? $input[0] : $input[$i+1];

	if ($input[$i] == $next) {
		$sum += $input[$i];
	}
}

echo("That equals " . $sum . "\n");