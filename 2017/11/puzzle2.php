<?php

/* As I solved part 1 in a way that took no notice of the "grid" I can't
   easily expand it to solve part 2... so this is going to be hacky!
*/

$input = trim(file_get_contents('input'));

// first, get a list of all the steps
$steps = explode(',', $input);
$numSteps = count($steps);

// now we are going to see how far away we are on the 1,2,...,n steps
$stepList = $steps[0];
$maxDistance = getShortestDistance($stepList);
echo("1 of " . $numSteps . "\n");
for ($i = 1; $i < count($steps); $i++) {
	echo($i+1 . " of " . $numSteps . "\n");
	$stepList .= ',' . $steps[$i];

	$distance = getShortestDistance($stepList);

	if ($distance > $maxDistance) {
		$maxDistance = $distance;
	}
}

echo('The child process gets a maximum of ' . $maxDistance . " steps away\n");


// this is basically the whole of part 1 packaged up
function getShortestDistance($input)
{
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

	return count($finalSteps);
}

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