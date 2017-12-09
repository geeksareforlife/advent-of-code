<?php

require('Registers.class.php');

$input = file('input');

$registers = new Registers();

foreach ($input as $instruction) {
	$registers->processInstruction($instruction);
}

$largest = $registers->getLargest();

echo("The largest register is " . $largest['register'] . " and it's value is " . $largest['value'] . "\n");