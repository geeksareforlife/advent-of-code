<?php

$input = file('input');

$tempTowers = [];

foreach ($input as $line) {
	$line = trim($line);
	if (strpos($line, '->') !== false) {
		$parts = explode(' -> ', $line);
		$line = $parts[0];
		$childList = explode(', ', $parts[1]);
		$children = [];
		foreach ($childList as $name) {
			$children[$name] = [];
		}
	} else {
		$children = [];
	}

	list($name, $weight) = explode(' ', $line);
	$weight = str_replace(['(', ')'], ['', ''], $weight);

	$tempTowers[$name] = [
		'weight'	=>	$weight,
		'children'	=>	$children
	];
}

$towers = buildTree($tempTowers);

// there is only one at this level now, but...
foreach ($towers as $name => $tower) {
	$bottom = $name;
}

echo("The bottom of the tree is called " . $bottom . "\n");


function buildTree($towers)
{
	while (count($towers) > 1) {
		$towers = buildTreeIteration($towers);
	}

	return $towers;
}

function buildTreeIteration($towers)
{
	$newTowers = [];

	$fullChildren = [];

	foreach ($towers as $name => $tower) {
		if (checkChildrenAreFull($tower['children'])) {
			$fullChildren[$name] = $tower;
		} else {
			$newTowers[$name] = $tower;
		}
	}

	foreach ($newTowers as $name => $tower) {
		foreach ($tower['children'] as $child => $childTower) {
			if (isset($fullChildren[$child])) {
				$newTowers[$name]['children'][$child] = $fullChildren[$child];
			}
		}
	}

	return $newTowers;
}

function checkChildrenAreFull($children)
{
	if (count($children) == 0) {
		// no children!
		return true;
	} else {
		foreach ($children as $name => $tower) {
			if ($tower == []) {
				// tower not in here yet!
				return false;
			} else {
				if (checkChildrenAreFull($tower['children']) === false) {
					return false;
				}
			}
		}
		// must all be full!
		return true;
	}
}