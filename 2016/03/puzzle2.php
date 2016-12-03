<?php

$input = file('input');

$possible = 0;
$impossible = 0;

$lines = [];

foreach ($input as $line) {
	$sides = getSides($line);
	$lines[] = $sides;
}

for ($i = 0; $i < count($lines); $i = $i+3) {

	$triangles = [
		[$lines[$i][0], $lines[$i+1][0], $lines[$i+2][0]],
		[$lines[$i][1], $lines[$i+1][1], $lines[$i+2][1]],
		[$lines[$i][2], $lines[$i+1][2], $lines[$i+2][2]],
	];

	foreach ($triangles as $triangle) {
		if (isTrianglePossible($triangle)) {
			$possible++;
		} else {
			$impossible++;
		}
	}
}

echo("Possible  : " . $possible . "\n");
echo("Impossible: " . $impossible . "\n");

function getSides($triangle)
{
	$triangle = str_replace('    ', ' ', $triangle);
	$triangle = str_replace('   ', ' ', $triangle);
	$triangle = str_replace('  ', ' ', $triangle);

	$sides = explode(' ', trim($triangle));

	return $sides;
}

function isTrianglePossible($sides)
{
	// there is almost certainly a better way of doing this
	if ($sides[0] + $sides[1] > $sides[2] and
		$sides[0] + $sides[2] > $sides[1] and
		$sides[1] + $sides[2] > $sides[0]) {
		return true;
	} else {
		return false;
	}
}