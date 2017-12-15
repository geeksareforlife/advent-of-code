<?php

$input = file('input');

$matched = 0;

$generators = [
	'A'	=>	[
		'factor' => 16807,
	],
	'B'	=>	[
		'factor' => 48271,
	],
];

foreach ($input as $generator) {
	preg_match('/Generator (A|B) starts with (\d*)/', $generator, $matches);

	$generators[$matches[1]]['start'] = intval($matches[2]);
	$generators[$matches[1]]['value'] = intval($matches[2]);
}

for ($i = 0; $i < 5000000; $i++) {
	foreach ($generators as $id => $generator) {
		$generators[$id]['value'] = getNewValue($id, $generator);
	}

	if (judge($generators)) {
		$matched++;
	}
}

echo("The judge saw " . $matched . " matches\n");


function getNewValue($id, $generator)
{
	$modulo = 2147483647;

	$divisors = [
		'A' => 4,
		'B' => 8,
	];

	$value = $generator['value'];

	while (1) {
		$value = ($value * $generator['factor']) % $modulo;
		if (($value % $divisors[$id]) === 0) {
			return $value;
		}
	}
}

function judge($generators)
{
	$bitmask = 65535;

	$tests = [];

	foreach ($generators as $generator) {
		$tests[] = $generator['value'] & $bitmask;
	}

	$test = $tests[0];

	for ($i = 1; $i < count($tests); $i++) {
		if ($tests[$i] !== $test) {
			return false;
		}
	}

	return true;
}