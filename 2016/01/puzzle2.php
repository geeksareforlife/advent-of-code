<?php

$input = 'R1, R1, R3, R1, R1, L2, R5, L2, R5, R1, R4, L2, R3, L3, R4, L5, R4, R4, R1, L5, L4, R5, R3, L1, R4, R3, L2, L1, R3, L4, R3, L2, R5, R190, R3, R5, L5, L1, R54, L3, L4, L1, R4, R1, R3, L1, L1, R2, L2, R2, R5, L3, R4, R76, L3, R4, R191, R5, R5, L5, L4, L5, L3, R1, R3, R2, L2, L2, L4, L5, L4, R5, R4, R4, R2, R3, R4, L3, L2, R5, R3, L2, L1, R2, L3, R2, L1, L1, R1, L3, R5, L5, L1, L2, R5, R3, L3, R3, R5, R2, R5, R5, L5, L5, R2, L3, L5, L2, L1, R2, R2, L2, R2, L3, L2, R3, L5, R4, L4, L5, R3, L4, R1, R3, R2, R4, L2, L3, R2, L5, R5, R4, L2, R4, L1, L3, L1, L3, R1, R2, R1, L5, R5, R3, L3, L3, L2, R4, R2, L5, L1, L1, L5, L4, L1, L1, R1';

$coords = [
	'x'	=> 0,
	'y'	=> 0,
];

$details = [
	[
		'direction'	=> 'N',
		'axis'		=> 'y',
		'modifier'	=>	1,
	],
	[
		'direction'	=> 'E',
		'axis'		=> 'x',
		'modifier'	=>	1,
	],
	[
		'direction'	=> 'S',
		'axis'		=> 'y',
		'modifier'	=>	-1,
	],
	[
		'direction'	=> 'W',
		'axis'		=> 'x',
		'modifier'	=>	-1,
	]
];

$currentDirection = 0;

$visited = ['0,0'];

$instructions = str_replace(' ', '', $input);
$instructions = str_getcsv($instructions);

foreach ($instructions as $instruction) {
	$direction = substr($instruction, 0, 1);
	$distance = substr($instruction, 1);

	$direction == 'R' ? $currentDirection++ : $currentDirection--;

	if ($currentDirection == 4) {
		$currentDirection = 0;
	} elseif ($currentDirection == -1) {
		$currentDirection = 3;
	}

	for ($i = 0; $i < $distance; $i++) {
		$coords[$details[$currentDirection]['axis']] = $coords[$details[$currentDirection]['axis']] + ($details[$currentDirection]['modifier']);
		$location = $coords['x'] . ',' . $coords['y'];

		if (in_array($location, $visited)) {
			break 2;
		} else {
			$visited[] = $location;
		}
	}

	
}

$blocks = abs($coords['x']) + abs($coords['y']);

echo('     X: ' . $coords['x'] . "\n");
echo('     Y: ' . $coords['y'] . "\n");
echo('Blocks: ' . $blocks . "\n");