<?php

$input = file('input');

// set up grid

$grid = array_fill(0, 1000, array_fill(0, 1000, 0));

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
					$grid[$y][$x] += 2;
				} else {
					if ($instruction == 'turn on') {
						$grid[$y][$x]++;
					} else {
						if ($grid[$y][$x] > 0) {
							$grid[$y][$x]--;
						}
					}
				}
			}
		}
	}
}

$brightness = 0;

foreach ($grid as $line) {
	$brightness += array_sum($line);
}

echo('BRIGHTNESS : ' . $brightness . "\n");
