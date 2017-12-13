<?php

$input = file('input');

$startingLayers = getLayers($input);

$numLayers = getNumLayers($startingLayers);

$delay = 0;

while (1) {
	$currentLayer = -1;
	$layers = $startingLayers;

	if ($delay % 10 === 0) {
		var_dump($delay);
	}

	$caught = [];

	for ($i = 0; $i < $numLayers; $i++) {
		// move into the next layer
		$currentLayer++;
		
		// does this layer have a firewall? is the scanner at 0?
		if (isset($layers[$currentLayer]) && $layers[$currentLayer]['position'] === 0) {
			$delay++;
			$startingLayers = moveScanners($startingLayers);
			continue 2;
		}

		$layers = moveScanners($layers);
	}

	break;
}

echo("We will need to delay for " . $delay . " picoseconds\n");


function getLayers($input)
{
	$layers = [];

	foreach ($input as $layer) {
		$layer = trim($layer);

		list($id, $size) = explode(': ', $layer);

		$layers[intval($id)] = [
			'size'		=>	intval($size),
			'position'	=>	0,
			'direction'	=>	'asc',
		];
	}

	return $layers;
}

function getNumLayers($layers)
{
	$numLayers = 0;

	foreach ($layers as $id => $layer) {
		if ($id > $numLayers) {
			$numLayers = $id;
		}
	}

	return $numLayers + 1;
}

function moveScanners($layers)
{
	foreach ($layers as $id => $layer) {
		if ($layers[$id]['direction'] === 'asc') {
			$layers[$id]['position'] = $layers[$id]['position'] + 1;
			if ($layers[$id]['position'] === ($layers[$id]['size'] - 1)) {
				$layers[$id]['direction'] = 'desc';
			}
		} elseif ($layers[$id]['direction'] === 'desc') {
			$layers[$id]['position'] = $layers[$id]['position'] - 1;
			if ($layers[$id]['position'] === 0) {
				$layers[$id]['direction'] = 'asc';
			}
		}
	}

	return $layers;
}

function calculateSeverity($caught, $layers)
{
	$severity = 0;

	foreach ($caught as $id) {
		$severity = $severity + ($id * $layers[$id]['size']);

	}

	return $severity;
}