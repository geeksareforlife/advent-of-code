<?php

$input = file('input');

$possible = 0;
$impossible = 0;

foreach ($input as $triangle) {
	$sides = getSides($triangle);

	if (isTrianglePossible($sides)) {
		$possible++;
	} else {
		$impossible++;
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