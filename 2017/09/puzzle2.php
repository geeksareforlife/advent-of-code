<?php

$input = trim(file_get_contents('input'));

// first, remove cancelled characters
$stream = removeCancelled($input);

$numGarbage = countGarbage($stream);

echo("The tree has " . $numGarbage . " garbage characters\n");


function removeCancelled($stream)
{
	return preg_replace('/\!./', '', $stream);
}

function countGarbage($stream)
{
	$num = 0;
	if (preg_match_all('/<([^>]*)>/', $stream, $matches)) {
		foreach ($matches[1] as $match) {
			$num = $num + strlen($match);
		}
	}
	return $num;
}
