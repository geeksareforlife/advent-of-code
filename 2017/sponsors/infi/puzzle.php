<?php

$input = trim(file_get_contents('input'));

list($bots, $steps) = explode('](', $input);

$bots = parseBots($bots);
$steps = parseSteps($steps);

$numBots = count($bots);
$numSteps = count($steps);

$clashes = 0;

for ($i = 0; $i < $numSteps; $i = $i + $numBots) {
	// move all the bots
	for ($j = 0; $j < $numBots; $j++) {
		$bots[$j] = applyStep($bots[$j], $steps[$i+$j]);
	}

	// any in the same place?
	if (samePlace($bots)) {
		$clashes++;
	}
}

echo("There were " . $clashes . " clashes\n");

function parseBots($botString)
{
	$botString = trim($botString, '[');

	$bots = [];

	foreach (explode('][', $botString) as $start)
	{
		list($x, $y) = explode(',', $start);
		$bots[] = [
			'x' => intval($x),
			'y'	=> intval($y)
		];
	}

	return $bots;
}

function parseSteps($stepsString)
{
	$stepsString = trim($stepsString, ')');

	$steps = [];

	foreach (explode(')(', $stepsString) as $step) {
		list($x, $y) = explode(',', $step);
		$steps[] = [
			'x' => intval($x),
			'y'	=> intval($y)
		];
	}

	return $steps;
}

function applyStep($bot, $step)
{
	return [
		'x'	=> $bot['x'] + $step['x'],
		'y'	=> $bot['y'] + $step['y'],
	];
}

function samePlace($bots)
{
	$places = [];

	foreach ($bots as $bot) {
		$place = $bot['x'] . ',' . $bot['y'];

		if (in_array($place, $places)) {
			// same place!
			return true;
		} else {
			$places[] = $place;
		}
	}
}