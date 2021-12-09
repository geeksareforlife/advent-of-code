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
			$lowpoints[] = ['x' => $x, 'y' => $y];
		}
	}
}

// now for each lowpoint, find the basin
// This is going out in every direction until we hit a wall, or a 9
$basins = [];
foreach ($lowpoints as $lowpoint) {
	$basin = findBasin($lowpoint, $locations, $maxX, $maxY);
	$basins[] = count($basin);
}

rsort($basins);

$total = $basins[0] * $basins[1] * $basins[2];

echo("The answer is " . $total . "\n");

function findBasin($point, $locations, $maxX, $maxY, $points = [])
{
	$x = $point['x'];
	$y = $point['y'];
	$points[] = $point;
	if ($y > 0) {
		if ($locations[$y-1][$x] !== 9) {
			$newPoint = ['x' => $x, 'y' => $y-1];
			if (!in_array($newPoint, $points)) {
				$points = findBasin($newPoint, $locations, $maxX, $maxY, $points);
			}
		}
	}
	if ($y < ($maxY-1)) {
		if ($locations[$y+1][$x] !== 9) {
			$newPoint = ['x' => $x, 'y' => $y+1];
			if (!in_array($newPoint, $points)) {
				$points = findBasin($newPoint, $locations, $maxX, $maxY, $points);
			}
		}
	}
	if ($x > 0) {
		if ($locations[$y][$x-1] !== 9) {
			$newPoint = ['x' => $x-1, 'y' => $y];
			if (!in_array($newPoint, $points)) {
				$points = findBasin($newPoint, $locations, $maxX, $maxY, $points);
			}
		}
	}
	if ($x < ($maxX-1)) {
		if ($locations[$y][$x+1] !== 9) {
			$newPoint = ['x' => $x+1, 'y' => $y];
			if (!in_array($newPoint, $points)) {
				$points = findBasin($newPoint, $locations, $maxX, $maxY, $points);
			}
		}
	}
	return $points;
}