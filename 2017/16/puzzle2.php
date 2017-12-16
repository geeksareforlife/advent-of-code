<?php

$file = 'input';

$input = file_get_contents($file);

$dancers = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p'];
$start = $dancers;

$target = 1000000000;

if ($file == 'input.test') {
	$dancers = array_slice($dancers, 0, 5);
}

$index = buildIndex($dancers);

$moves = getMoves($input);

$cycle = 0;
while (1) {
	$dancers = doDance($dancers, $moves, $index);

	if ($dancers == $start) {
		break;
	}
	$cycle++;
}

$dancers = $start;
for ($i = 0; $i < $target % ($cycle + 1); $i++) {
	$dancers = doDance($dancers, $moves, $index);	
}

echo("At the end, the dancers's positions were:\n");
printDancers($dancers);


function doDance($dancers, $moves, &$index)
{
	foreach ($moves as $move) {
		if ($move['type'] == 's') {
			$dancers = spin($dancers, $move['number'], $index);
		} elseif ($move['type'] == 'x') {
			$dancers = exchange($dancers, $move['dancers'], $index);
		} elseif ($move['type'] == 'p') {
			$dancers = partner($dancers, $move['dancers'], $index);
		}
	}

	return $dancers;
}

function buildIndex($dancers)
{
	$index = [];

	for ($i = 0; $i < count($dancers); $i++) {
		$index[$dancers[$i]] = $i;
	}

	return $index;
}

function getMoves($input)
{
	$allMoves = explode(',', trim($input));

	$moves = [];
	foreach ($allMoves as $move) {
		$type = $move[0];
		$instruction = substr($move, 1);

		if ($type == 's') {
			$moves[] = [
				'type'	 	=>	$type,
				'number' 	=>	intval($instruction),
			];
		} elseif ($type == 'x') {
			$moves[] = [
				'type'		=>	$type,
				'dancers'	=>	array_map('intval', explode('/', $instruction)),
			];
		} elseif ($type == 'p') {
			$moves[] = [
				'type'		=>	$type,
				'dancers'	=>	explode('/', $instruction),
			];
		}
	}

	return $moves;
}

function printDancers($dancers)
{
	$string = '';

	foreach ($dancers as $dancer) {
		$string .= $dancer;
	}

	echo($string . "\n");
}

function spin($dancers, $number, &$index)
{
	$start = array_slice($dancers, -1 * $number);
	$end = array_slice($dancers, 0, count($dancers) - $number);

	$newDancers = array_merge($start, $end);

	$index = buildIndex($newDancers);
	return $newDancers;
}

function exchange($dancers, $movers, &$index)
{
	$dancer0 = $dancers[$movers[0]];
	$dancer1 = $dancers[$movers[1]];

	$dancers[$movers[0]] = $dancer1;
	$dancers[$movers[1]] = $dancer0;


	$index = buildIndex($dancers);
	return $dancers;
}

function partner($dancers, $movers, &$index)
{
	$position0 = $index[$movers[0]];
	$position1 = $index[$movers[1]];

	$dancers[$position0] = $movers[1];
	$dancers[$position1] = $movers[0];

	$index = buildIndex($dancers);
	return $dancers;
}