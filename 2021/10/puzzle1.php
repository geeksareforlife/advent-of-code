<?php

$lines = file("input");

$incompleteLines = [];

$points = [
	")" => 3,
	"]" => 57,
	"}" => 1197,
	">" => 25137
];

$errorScore = 0;

foreach ($lines as $line) {
	$return = parseLine(trim($line));

	if ($return['status'] == "error") {
		$errorScore = $errorScore + $points[$return['found']];
	} else {
		$incompleteLines[] = trim($line);
	}
}

echo("The total syntax error score is " . $errorScore . "\n");


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

	return $return;
}