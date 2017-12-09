<?php

$input = file('input');

$bots = [];
$outputs = [];

$botBase = [
	'values'	=> [],
	'high'		=> false,
	'low'		=> false,
];

// set inital state
foreach ($input as $line) {
	$instruction = trim($line);
	if (preg_match('/^value (\d{1,3}) goes to bot (\d{1,3})$/', $instruction, $matches)) {
		$bot = intval($matches[2]);
		$value = intval($matches[1]);

		if (!isset($bots[$bot])) {
			$bots[$bot] = $botBase;
		}

		$bots[$bot]['values'][] = $value;
	} elseif (preg_match('/^bot (\d{1,3}) gives low to (bot|output) (\d{1,3}) and high to (bot|output) (\d{1,3})$/', $instruction, $matches)) {
		$bot = $matches[1];
		$high = [
			'type'	=>	$matches[4],
			'id'	=>	$matches[5],
		];
		$low = [
			'type'	=>	$matches[2],
			'id'	=>	$matches[3],
		];

		if (!isset($bots[$bot])) {
			$bots[$bot] = $botBase;
		}

		$bots[$bot]['high'] = $high;
		$bots[$bot]['low'] = $low;
	}
}


// run simulation
$step = 0;
while ($bots !== true) {
	if (botsAreEmpty($bots)) {
		break;
	}
	echo("STEP    :" . $step . "\n");
	$bots = step($bots);
	$step++;
	flush();
}

$answer = $outputs[0] * $outputs[1] * $outputs[2];

echo("The answer is " . $answer . "\n");

function step($bots) {
	global $outputs;
	
	for ($i = 0; $i < count($bots); $i++) {
		if (count($bots[$i]['values']) == 2) {
			$low = min($bots[$i]['values']);
			$high = max($bots[$i]['values']);

			$bots[$i]['values'] = [];

			if ($bots[$i]['low']['type'] == 'output') {
				$outputs[$bots[$i]['low']['id']] = $low;
			} else {
				$bots[$bots[$i]['low']['id']]['values'][] = $low;
			}

			if ($bots[$i]['high']['type'] == 'output') {
				$outputs[$bots[$i]['high']['id']] = $high;
			} else {
				$bots[$bots[$i]['high']['id']]['values'][] = $high;
			}
		}
	}

	return $bots;
}

function botsAreEmpty($bots) {
	$empty = true;
	for ($i = 0; $i < count($bots); $i++) {
		if (count($bots[$i]['values']) > 0) {
			return false;
		}
	}

	return $empty;
}