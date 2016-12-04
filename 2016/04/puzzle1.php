<?php

$input = file('input');

$sectorIdSum = 0;

echo("REAL ROOMS\n----------\n\n");

foreach ($input as $room) {
	if (preg_match('/([a-z\-]*)-(\d{3})\[([a-z]{5})/', $room, $matches)) {
		$name = $matches[1];
		$sectorId = $matches[2];
		$checksum = $matches[3];

		if (calculateChecksum($name) == $checksum) {
			echo($name . "\t" . $sectorId . "\n");

			$sectorIdSum += $sectorId;
		}
	}
}

echo('SUM: ' . $sectorIdSum . "\n");

function calculateChecksum($name) {
	$letterCounts = [];
	for ($i = 0; $i < strlen($name); $i++) {
		if ($name[$i] == '-') {
			continue;
		} else {
			if ( ! isset($letterCounts[$name[$i]])) {
				$letterCounts[$name[$i]] = 0;
			}
			$letterCounts[$name[$i]]++;
		}
	}

	$newLetterCounts = [];

	// reformat array for sorting
	foreach ($letterCounts as $letter => $count) {
		$newLetterCounts[] = [
			'letter'	=>	$letter,
			'count'		=>	$count,
		];
	}

	usort($newLetterCounts, 'sortCounts');

	$checksum = '';
	for ($i = 0; $i < 5; $i++) {
		$checksum .= $newLetterCounts[$i]['letter'];
	}

	return $checksum;
}

function sortCounts($a, $b) {
	if ($a['count'] == $b['count']) {
		return strcmp($a['letter'], $b['letter']);
	} elseif ($a['count'] > $b['count']) {
		return -1;
	} else {
		return 1;
	}
}