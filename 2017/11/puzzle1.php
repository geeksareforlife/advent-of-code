<?php

$input = trim(file_get_contents('input'));

// these can be either way round
// it also seems that there can be multiple other steps between them
$replacements = [
	['steps' => ['n', 's'], 'with' => ''],
	['steps' => ['ne', 'sw'], 'with' => ''],
	['steps' => ['nw', 'se'], 'with' => ''],
	['steps' => ['n', 'se'], 'with' => 'ne'],
	['steps' => ['n', 'sw'], 'with' => 'nw'],
	['steps' => ['ne', 's'], 'with' => 'se'],
	['steps' => ['ne', 'nw'], 'with' => 'n'],
	['steps' => ['nw', 's'], 'with' => 'sw'],
	['steps' => ['se', 'sw'], 'with' => 's'],
];

$steps = ['n', 'ne', 'se', 's', 'sw', 'nw'];

// each iteration changes the input, meaning that previouslt tested patterns
// may match again
$changes = true;
while ($changes) {
	$changes = false;
	foreach ($replacements as $replacement) {
		$search = getSearch($steps, $replacement['steps']);

		$patterns = [
			'/' . $replacement['steps'][0] . ',((' . $search . ',)*)' . $replacement['steps'][1] . '(,|$)/',
			'/' . $replacement['steps'][1] . ',((' . $search . ',)*)' . $replacement['steps'][0] . '(,|$)/'
		];

		$matches = [];

		// replace these patterns as many times as possible
		foreach ($patterns as $pattern) {
			while (preg_match($pattern, $input, $matches)) {
				$new = $replacement['with'] . ',';
				if (isset($matches[1])) {
					$new .= $matches[1];
				}

				if ($new == ',') {
					$new = '';
				}
				// only replace the first match!
				$input = preg_replace($pattern, $new, $input, 1);

				// get rid of any double commas
				$input = str_replace(',,', ',', $input);

				$changes = true;

				$matches = [];
			}
		}
	}
}

$input = trim($input, ',');

if ($input == '') {
	$finalSteps = [];
} else {
	$finalSteps = explode(',', $input);
}

echo("The child process is " . count($finalSteps) . " steps away\n"); 

function getSearch($steps, $exclude)
{
	$search = [];
	foreach ($steps as $step) {
		if ( ! in_array($step, $exclude)) {
			$search[] = $step;
		}
	}

	return '(' . implode('|', $search) . ')';
}