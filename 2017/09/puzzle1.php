<?php

$input = trim(file_get_contents('input'));

// first, remove cancelled characters
$stream = removeCancelled($input);

$stream = removeGarbage($stream);

$tree = buildTree($stream);

$score = scoreTree($tree);

echo("The tree has a score " . $score . "\n");


function removeCancelled($stream)
{
	return preg_replace('/\!./', '', $stream);
}

function removeGarbage($stream)
{
	return preg_replace('/<[^>]*>/', '', $stream);
}

function buildTree($stream, $level = 1)
{
	$tree = [];

	$i = 0;
	$len = strlen($stream);

	$inGroup = false;
	$opened = 0;
	$newStream = '';

	while ($i < $len) {
		$char = $stream[$i];

		if ($char == '{' && $inGroup === false) {
			$inGroup = true;
			$i++;
			$newStream = '';
		} elseif ($char == '}' && $opened == 0) {
			$inGroup = false;
			$i++;
			$tree[] = [
				'score'		=>	$level,
				'children'	=>	buildTree($newStream, $level+1),
			];
		} elseif ($char == '{' && $inGroup === true) {
			$opened++;
			$i++;
			$newStream = $newStream . $char;
		} elseif ($char == '}' && $inGroup === true) {
			$opened--;
			$i++;
			$newStream = $newStream . $char;
		} else {
			$i++;
			$newStream = $newStream . $char;
		}
	}

	return $tree;
}

function scoreTree($tree)
{
	$score = 0;
	foreach ($tree as $group) {
		$score = $score + $group['score'];
		$score = $score + scoreTree($group['children']);
	}
	return $score;
}