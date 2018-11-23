<?php

$input = file('input');

$instructions = processInstructions($input);

$programs = [
	[
		'id'		=> 0,
		'sendto'	=> 1,
		'registers'	=> ['p' => 0],
		'sentCount'	=> 0,
		'position'	=> 0,
		'incoming'	=> [],
		'status'	=> 'running'
	],
	[
		'id'		=> 1,
		'sendto'	=> 0,
		'registers'	=> ['p' => 1],
		'sentCount'	=> 0,
		'position'	=> 0,
		'incoming'	=> [],
		'status'	=> 'running'
	]
];

while (1) {
	for ($p = 0; $p < count($programs); $p++) {
		if ($programs[$p]['position'] >= count($instructions)) {
			// end of the program
			$programs[$p]['status'] = "stopped";
		}

		if ($programs[$p]['status'] != "stopped") {
			$instruction = $instructions[$programs[$p]['position']];

			switch ($instruction['type']) {
				case 'set':
				case 'add':
				case 'mul':
				case 'mod':
					$programs[$p]['registers'] = doArithmetic($instruction['type'], $instruction['register'], $instruction['value'], $programs[$p]['registers']);
					$programs[$p]['position']++;
					break;
				case 'snd':
					//echo("Program " . $p . " sent " . getValue($instruction['value'], $programs[$p]['registers']) . " @ instruction " . $programs[$p]['position'] . "\n");
					$programs[$programs[$p]['sendto']]['incoming'][] = getValue($instruction['value'], $programs[$p]['registers']);
					$programs[$p]['sentCount']++;
					$programs[$p]['position']++;
					// $lastSound = playSound($instruction['value'], $registers);
					// $i++;
					break;
				case 'jgz':
					$programs[$p]['position'] = $programs[$p]['position'] + doJump($instruction['register'], $instruction['value'], $programs[$p]['registers']);
					break;
				case 'rcv':
					// check the queue
					if (count($programs[$p]['incoming']) > 0) {
						// we have a value!
						$value = [
							'type'		=>	'integer',
							'value'		=>	array_shift($programs[$p]['incoming']),
						];
						//echo("Program " . $p . " received " . $value['value'] . " @ instruction " . $programs[$p]['position'] . "\n");
						$programs[$p]['registers'] = doArithmetic("set", $instruction['value'], $value, $programs[$p]['registers']);
						$programs[$p]['position']++;
						//var_dump($programs[$p]['registers']);
					} else {
						// nothing in the queue. change to waiting and try again next time
						$programs[$p]['status'] = "waiting";
					}
					// if (recover($instruction['value'], $registers)) {
					// 	break 2;
					// }
					// $i++;
				default:
					# code...
					break;
			}
		}
	}

	//var_dump($programs);

	// status check
	$numRunning = 0;
	for ($p = 0; $p < count($programs); $p++) {
		if ($programs[$p]['status'] == "running") {
			$numRunning++;
		}
	}

	if ($numRunning == 0) {
		// we are done!
		break;
	}
}

echo("Program 1 sent " . $programs[1]['sentCount'] . " times\n");


function processInstructions($input)
{
	$instructions = [];

	foreach ($input as $line) {
		$instructions[] = processInstruction(trim($line));
	}

	return $instructions;
}

function processInstruction($line)
{
	$parts = explode(' ', $line);

	if (count($parts) == 2) {
		$value = $parts[1];
		$registerType = '';
		$register = '';
	} else {
		$value = $parts[2];
		if ($parts[0] === 'jgz' && ! preg_match('/[a-z]/', $parts[1])) {
			// register is not actually a register!
			$registerType = 'integer';
			$register = intval($parts[1]);
		} else {
			$registerType = 'register';
			$register = $parts[1];
		}
	}

	if (preg_match('/[a-z]/', $value)) {
		$valueType = 'register';
	} else {
		$valueType = 'integer';
		$value = intval($value);
	}

	return [
		'type'		=>	$parts[0],
		'register'	=>	[
			'type'		=>	$registerType,
			'value'		=>	$register,
		],
		'value'		=>	[
			'type'		=>	$valueType,
			'value'		=>	$value,
		],
	];
}

function createRegister() {
	return 0;
}

function getValue($value, $registers)
{
	if ($value['type'] === 'integer') {
		return $value['value'];
	} else {
		if (isset($registers[$value['value']])) {
			return $registers[$value['value']];
		} else {
			return 0;
		}
	}
}

function doArithmetic($type, $register, $value, $registers)
{
	$registerId = $register['value'];
	// create the register if needed
	if (! isset($registers[$registerId])) {
		$registers[$registerId] = createRegister();
	}

	if ($type === 'set') {
		$registers[$registerId] = getValue($value, $registers);
	} elseif ($type === 'add') {
		$registers[$registerId] = $registers[$registerId] + getValue($value, $registers);
	} elseif ($type === 'mul') {
		$registers[$registerId] = $registers[$registerId] * getValue($value, $registers);
	} elseif ($type === 'mod') {
		$registers[$registerId] = $registers[$registerId] % getValue($value, $registers);
	}

	return $registers;
}

function playSound($value, $registers)
{
	return getValue($value, $registers);
}

function doJump($register, $value, $registers)
{
	if (getValue($register, $registers) > 0) {
		return getValue($value, $registers);
	} else {
		// we still need move at least 1!
		return 1;
	}
}

function recover($value, $registers)
{
	if (getValue($value, $registers) === 0) {
		return false;
	} else {
		return true;
	}
}