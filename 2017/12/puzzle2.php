<?php

$input = file('input');

$programs = [];
$inGroups = [];
$groups = [];

foreach ($input as $program) {
	list($id, $connections) = explode(' <-> ', trim($program));
	$connections = explode(', ', $connections);
	$programs[$id] = array_map('intval', $connections);
}

foreach ($programs as $id => $connections) {
	if ( ! in_array($id, $inGroups)) {
		$connected = getConnected([$id], $programs);
		$groups[] = $connected;
		$inGroups = array_merge($inGroups, $connected);
	}
}

echo("There are " . count($groups) . " groups of programs\n");


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