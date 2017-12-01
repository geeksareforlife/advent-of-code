<?php

$input = trim(file_get_contents('input'));

$sum = 0;

$length = strlen($input);

for ($i = 0; $i < $length; $i++) {
	$nextI = ($i + ($length/2)) % $length;

	if ($input[$i] == $input[$nextI]) {
		$sum += $input[$i];
	}
}

echo("That equals " . $sum . "\n");