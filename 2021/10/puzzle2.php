<?php

$lines = file("input");

$points = [
	")" => 1,
	"]" => 2,
	"}" => 3,
	">" => 4
];

$errorScores = [];

foreach ($lines as $line) {
	$return = parseLine(trim($line));

	if ($return['status'] == "error") {
		// throw away
	} else {
		$score = 0;
		for ($i = 0; $i < count($return['required']); $i++) {
			$score = ($score * 5) + $points[$return['required'][$i]];
		}
		$errorScores[] = $score;
	}
}

// get the middle score (always odd)
sort($errorScores);

$middle = (count($errorScores) - 1) / 2;

echo("The middle score is " . $errorScores[$middle] . "\n");



function parseLine($line)
{
	$closing = [
		"(" => ")",
		"[" => "]",
		"{" => "}",
		"<" => ">"
	];
	$opening = array_keys($closing);

	$return = [
		'status' => 'incomplete',
	];

	$characters = str_split($line);
	$opened = [$characters[0]];
	$currentOpen = $characters[0];

	for ($i = 1; $i < count($characters); $i++) {
		if (in_array($characters[$i], $opening)) {
			array_push($opened, $characters[$i]);
			$currentOpen = $characters[$i];
		} else {
			// must be a closing
			if (count($opened) == 0) {
				// nothing to close, incomplete
				break;
			} else if ($characters[$i] == $closing[$currentOpen]) {
				// closed fine
				array_pop($opened);
				if (count($opened) > 0) {
					$currentOpen = $opened[count($opened)-1];
				} else {
					$currentOpen = "";
				}
			} else {
				// failed to close
				$return['status'] = 'error';
				$return['found'] = $characters[$i];
				break;
			}
		}
	}

	if ($return['status'] == "incomplete") {
		$opened = array_reverse($opened);
		$return['opened'] = $opened;
		$return['required'] = [];
		for ($i = 0; $i < count($opened); $i++) {
			$return['required'][] = $closing[$opened[$i]];
		}
	}

	return $return;
}