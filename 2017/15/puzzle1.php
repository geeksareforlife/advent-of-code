<?php

$input = file('input');

$matched = 0;

$modulo = 2147483647;

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

for ($i = 0; $i < 40000000; $i++) {
	foreach ($generators as $id => $generator) {
		$generators[$id]['value'] = ($generator['value'] * $generator['factor']) % $modulo;
	}

	if (judge($generators)) {
		$matched++;
	}
}

echo("The judge saw " . $matched . " matches\n");


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