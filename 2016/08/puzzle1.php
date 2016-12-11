<?php

$input = file('input');

$rows = 6;
$columns = 50;

// create our display
// array of rows.
$display = [];

for ($i = 0; $i < $rows; $i++) {
	$display[$i] = array_fill(0, $columns, 0);
}

foreach ($input as $instruction) {
	$instruction = trim($instruction);
	if (substr($instruction, 0, 4) == 'rect') {
		list($x, $y) = explode('x', substr($instruction, 5));
		for ($i = 0; $i < $y; $i++) {
			for ($j = 0; $j < $x; $j++) {
				$display[$i][$j] = 1;
			}
		}
	} elseif (substr($instruction, 0, 10) == 'rotate row') {
		list($row, $number) = explode(' by ', substr($instruction, 13));
		for ($i = 0; $i < $number; $i++) {
			$end = array_pop($display[$row]);
			array_unshift($display[$row], $end);
		}
	} elseif (substr($instruction, 0, 13) == 'rotate column') {
		list($column, $number) = explode(' by ', substr($instruction, 16));
		for ($i = 0; $i < $number; $i++) {
			$thisValue = $display[0][$column];
			for ($j = 0; $j < $rows; $j++) {
				if (($j+1) == $rows) {
					$nextRow = 0;
				} else {
					$nextRow = $j+1;
				}
				$nextValue = $display[$nextRow][$column];
				$display[$nextRow][$column] = $thisValue;

				$thisValue = $nextValue;
			}
		}
	}
}


display($display);
numberLit($display);


// debugging
function display($display) {
	echo("DISPLAY:\n");
	foreach ($display as $row) {
		foreach ($row as $pixel) {
			if ($pixel == 1) {
				echo('#');
			} else {
				echo('.');
			}
		}
		echo("\n");
	}
}

function numberLit($display) {
	$lit = 0;
	foreach ($display as $row) {
		$lit += array_sum($row);
	}
	echo('LIT: ' . $lit . "\n");
}