<?php

$input = 265149;

$grid[0][0] = 1;

$layer = 1;
while (1) {
	$found = calculateLayer($layer, $input);
	if ($found) {
		echo("The first larger value is " . $found . "\n");
		break;
	}
	$layer++;
}


function calculateLayer($layer, $search)
{
	global $grid;

	// we have to do this in the right order.
	// all the time checking if we have exceeded search
	
	// first, start all the way to the right, one up from the bottom
	// move up to layer, layer
	for ($i = ((-1*$layer)+1); $i <= $layer; $i++) {
		$grid[$layer][$i] = sumEightValues($layer, $i);
		if ($grid[$layer][$i] > $search) {
			return $grid[$layer][$i];
		}
	}
	// now we are at layer,layer.  We need to move left to -layer, layer
	for ($i = $layer; $i >= ($layer*-1); $i--) {
		$grid[$i][$layer] = sumEightValues($i, $layer);
		if ($grid[$i][$layer] > $search) {
			return $grid[$i][$layer];
		}
	}
	// now we are at -layer, layer. We need to move down to -layer,-layer
	for ($i = $layer; $i >= ($layer*-1); $i--) {
		$grid[$layer*-1][$i] = sumEightValues($layer*-1, $i);
		if ($grid[$layer*-1][$i] > $search) {
			return $grid[$layer*-1][$i];
		}
	}
	// now we are at -layer, -layer. We need to move right to layer, -layer
	for ($i = (-1*$layer); $i <= $layer; $i++) {
		$grid[$i][$layer*-1] = sumEightValues($i, $layer*-1);
		if ($grid[$i][$layer*-1] > $search) {
			return $grid[$i][$layer*-1];
		}
	}

	// not found it this time
	return false;
}

function sumEightValues($x, $y)
{
	global $grid;

	$sum = 0;

	for ($i = -1; $i <= 1; $i++) {
		for ($j = -1; $j <= 1; $j++) {
			if ($i == 0 && $j == 0) {
				//ignore, this is the value we are calculating!
			} else {
				if (isset($grid[$x+$i][$y+$j])) {
					$sum += $grid[$x+$i][$y+$j];
				}
			}
		}
	}

	return $sum;
}