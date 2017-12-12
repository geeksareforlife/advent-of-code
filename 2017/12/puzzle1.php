<?php

$input = file('input');

$programs = [];

foreach ($input as $program) {
	list($id, $connections) = explode(' <-> ', trim($program));
	$connections = explode(', ', $connections);
	$programs[$id] = array_map('intval', $connections);
}

$connected = getConnected([0], $programs);

echo("There are " . count($connected) . " programs in 0's group\n");


function getConnected($ids, $programs)
{
	$connected = $ids;

	$new = [];
	foreach ($ids as $id) {
		foreach ($programs[$id] as $connection) {
			if ( ! in_array($connection, $connected)) {
				$new[] = $connection;
			}
		}
	}
	if (count($new) > 0) {
		$connected = array_merge($connected, $new);
		$connected = array_unique($connected);
		$connected = array_merge(getConnected($connected, $programs));
	}

	return $connected;
}