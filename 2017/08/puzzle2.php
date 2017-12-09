<?php

require('Registers.class.php');

$input = file('input');

$registers = new Registers();

foreach ($input as $instruction) {
	$registers->processInstruction($instruction);
}

$largest = $registers->getLargestEver();

echo("The register that gets the largest is " . $largest['register'] . " and it's maximum value is " . $largest['value'] . "\n");