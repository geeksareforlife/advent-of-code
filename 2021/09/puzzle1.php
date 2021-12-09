<?php

$readings = file("input");

// store y as the primary dimension, x secondary
// traditional AoC array!
$locations = [];

foreach ($readings as $reading) {
	$row = str_split(trim($reading));

	$locations[] = array_map('intval', $row);
}

$maxY = count($locations);
$maxX = count($locations[0]);

// let's find the low points
// a low point is one where all vertical and horizontal neighbours are higher
$lowpoints = [];

for ($y = 0; $y < $maxY; $y++) {
	for ($x = 0; $x < $maxX; $x++) {
		$height = $locations[$y][$x];
		$low = true;
		if ($y > 0) {
			if ($locations[$y-1][$x] <= $height) {
				$low = false;
			}
		}
		if ($y < ($maxY-1)) {
			if ($locations[$y+1][$x] <= $height) {
				$low = false;
			}
		}
		if ($x > 0) {
			if ($locations[$y][$x-1] <= $height) {
				$low = false;
			}
		}
		if ($x < ($maxX-1)) {
			if ($locations[$y][$x+1] <= $height) {
				$low = false;
			}
		}

		if ($low) {
			$lowpoints[] = $height;
		}
	}
}

$totalRiskLevel = array_sum($lowpoints) + count($lowpoints);

echo("The total risk level is " . $totalRiskLevel . "\n");