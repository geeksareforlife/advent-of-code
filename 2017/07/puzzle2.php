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
		'total'		=>	$weight,
		'weight'	=>	$weight,
		'children'	=>	$children
	];
}

$towers = buildTree($tempTowers);

// there is only one at this level now, but...
foreach ($towers as $name => $tower) {
	$bottom = $name;
}

$inbalance = findInbalance($bottom, $tower);

var_dump($inbalance);


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
				$newTowers[$name]['total'] = $newTowers[$name]['total'] + $fullChildren[$child]['total'];
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

function findInbalance($name, $tower)
{
	$balanced = checkBalance($tower['children'], getTarget($tower));
	
	if ($balanced !== true) {
		uasort($balanced, 'sortWeights');

		$weights = array_keys($balanced);

		$unbalancedTowerName = array_shift($balanced)[0];
		$unbalancedTower = $tower['children'][$unbalancedTowerName];

		if (checkBalance($unbalancedTower['children'], getTarget($unbalancedTower)) === true) {
			// this is the problem!
			return [
				'tower' 	=> $unbalancedTowerName,
				'newWeight'	=> $unbalancedTower['weight'] - ($weights[0] - $weights[1]),
			];
		} else {
			return findInbalance($unbalancedTowerName, $unbalancedTower);
		}

	} else {
		return true;
	}
}

function getTarget($tower)
{
	if (count($tower['children']) > 0) {
		return ($tower['total'] - $tower['weight']) / count($tower['children']);
	} else {
		return 0;
	}
}

function checkBalance($towers, $target)
{
	$balanced = true;
	$weights = [];
	foreach ($towers as $name => $tower) {
		if ( ! isset($weights[$tower['total']])) {
			$weights[$tower['total']] = [];
		}
		$weights[$tower['total']][] = $name;

		if (intval($tower['total']) !== $target) {
			$balanced = false;
		}
	}

	if ($balanced) {
		return true;
	} else {
		return $weights;
	}
}

function sortWeights($a, $b)
{
	if (count($a) == count($b)) {
		return 0;
	}

	return (count($a) < count($b)) ? -1 : 1;
}