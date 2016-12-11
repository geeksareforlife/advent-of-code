<?php

$input = file_get_contents('input');

$input = str_replace("\n", '', $input);

$decompressedLength = calculateLength($input);

echo('LENGTH: ' . $decompressedLength . "\n");


function calculateLength($remain) {
	$decompressedLength = 0;

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
			if (strpos($repeatString, '(') !== false) {
				$decompressedLength += calculateLength($repeatString) * $repeat;
			} else {
				$decompressedLength += $length * $repeat;
			}
		} else {
			$decompressedLength += 1;
		}

		$remain = substr($remain, $toRemove);
	}

	return $decompressedLength;
}