<?php

// Lots of thinking about this puzzle in thinking.md


$input = 265149;

$steps = getSteps($input);

echo("It will take " . $steps . " steps\n");




function getSteps($input)
{
	$axisCoefficients = [1, 3, 5, 7];

	// first find the layer the input is in
	$layer = findLayerForValue($input);

	/* now work out the quadrant - we want the two axis it is between
	   if is is in the lower right quadrant, the we won't find it using
	   the algorithm below, so assume it is that!
	   */
	$start = 3;
	for ($i = 0; $i < count($axisCoefficients); $i++) {
		$test = getValueAtLayer($layer, $axisCoefficients[$i]);
		if ($test == $input) {
			// special case, the value is on an axis, so the steps are equal to the layer
			return $layer;
		} elseif ($test > $input) {
			$start = $i-1;
			break;
		}
	}

	// two possibilities:
	// 1. the value will be reached from the value in the start axis and moving perpendicular (increasing values)
	// 2. the value will be reached from the value in the end axis and moving perpendicular (decreasing values)
	// If start = 3, then end is 0 on layer+1
	$startValue = getValueAtLayer($layer, $axisCoefficients[$start]);
	if (($startValue + $layer) >= $input) {
		return $layer + ($input - $startValue);
	} elseif ($start < 3) {
		$endValue = getValueAtLayer($layer, $axisCoefficients[$start+1]);
		return $layer + ($endValue - $input);
	} else {
		$endValue = getValueAtLayer($layer+1, $axisCoefficients[0]);
		return ($layer + 1) + ($endValue - $input);
	}
}

function getValueAtLayer($n, $C)
{
	return 1 + ($n*$C) + (getTriangleNumber($n-1)*8);
}

function getTriangleNumber($n)
{
	return ($n * ($n+1)) / 2;
}

function findLayerForValue($find)
{
	// we are looking at the first axis (C = 1)
	$n = 1;
	$previous = 1;

	while (1) {
		$current = getValueAtLayer($n, 1); //C = 1
		if ($find >= $previous && $find < $current) {
			return $n-1;
		}
		$n++;
	}
}