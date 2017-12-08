<?php

$input = file_get_contents('input');

$banks = explode("\t", $input);
$banks = array_map('intval', $banks);
$numBanks = count($banks);

$signatures = [];

$signatures[] = getSignature($banks);

$cycles = 0;

while (1) {
	$cycles++;

	// reallocation START
	$bankId = getBankToReallocate($banks);

	// get the blocks to reallocate
	$blocks = $banks[$bankId];

	// zero the bank
	$banks[$bankId] = 0;

	// give them to other banks
	$currentBank = ($bankId + 1) % $numBanks;
	while ($blocks > 0) {
		$banks[$currentBank]++;
		$currentBank = ($currentBank + 1) % $numBanks;
		$blocks--;
	}

	// store the signature
	$signature = getSignature($banks);
	if (in_array($signature, $signatures)) {
		break;
	} else {
		$signatures[] = $signature;
	}
}

echo("Infinite loop detected after " . $cycles . " cycles\n");



function getSignature($banks)
{
	return implode('-', $banks);
}

function getBankToReallocate($banks)
{
	$bank = 0;
	$max = 0;

	for ($i = 0; $i < count($banks); $i++) {
		if ($banks[$i] > $max) {
			$max = $banks[$i];
			$bank = $i;
		}
	}
	return $bank;
}