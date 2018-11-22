<?php

$input = file('input');

$instructions = processInstructions($input);

$lastSound = 0;

$registers = [];

$i = 0;

while (1) {
	$instruction = $instructions[$i];

	switch ($instruction['type']) {
		case 'set':
		case 'add':
		case 'mul':
		case 'mod':
			$registers = doArithmetic($instruction['type'], $instruction['register'], $instruction['value'], $registers);
			$i++;
			break;
		case 'snd':
			$lastSound = playSound($instruction['value'], $registers);
			$i++;
			break;
		case 'jgz':
			$i = $i + doJump($instruction['register'], $instruction['value'], $registers);
			break;
		case 'rcv':
			if (recover($instruction['value'], $registers)) {
				break 2;
			}
			$i++;
		default:
			# code...
			break;
	}
}

echo("The recovered sound was " . $lastSound . "\n");


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