<?php

$input = file('input');

// set up grid

$grid = array_fill(0, 1000, array_fill(0, 1000, -1));

foreach ($input as $line) {
	$matches = [];
	if (preg_match('/(turn on|turn off|toggle) (\d{0,3}),(\d{0,3}) through (\d{0,3}),(\d{0,3})/', trim($line), $matches)) {
		$instruction = $matches[1];
		$start = [
			'x' => $matches[2],
			'y' => $matches[3]
		];
		$end = [
			'x' => $matches[4],
			'y' => $matches[5]
		];

		for ($y = $start['y']; $y <= $end['y']; $y++) {
			for ($x = $start['x']; $x <= $end['x']; $x++) {
				if ($instruction == 'toggle') {
					$grid[$y][$x] *= -1;
				} else {
					if ($instruction == 'turn on') {
						$grid[$y][$x] = 1;
					} else {
						$grid[$y][$x] = -1;
					}
				}
			}
		}
	}
}

$on = 0;
$off = 0;

foreach ($grid as $line) {
	$values = array_count_values($line);
	isset($values[1]) ? $on = $on + $values[1]: '';
	isset($values[-1]) ? $off = $off + $values[-1]: '';
}

echo('ON : ' . $on . "\n");
echo('OFF: ' . $off . "\n");
