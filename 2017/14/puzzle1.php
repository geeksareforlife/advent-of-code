<?php

$input = trim(file_get_contents('input'));

$numRows = 128;
$rowHashes = [];

$grid = [];

for ($i = 0; $i < $numRows; $i++) {
	$rowId = $input . '-' . $i;
 	$rowHashes[] = getKnotHash($rowId);
}

foreach ($rowHashes as $hash) {
	$grid[] = getColumns($hash);
}

echo("In this grid, " . calculateUsedSquares($grid) . " squares are used\n");


function getColumns($hash)
{
	$columns = [];

	for ($i = 0; $i < strlen($hash); $i++) {
		$binary = str_pad(decbin(hexdec($hash[$i])), 4, "0", STR_PAD_LEFT);
		for ($j = 0; $j < strlen($binary); $j++) {
			$columns[] = intval($binary[$j]);
		}
	}

	return $columns;
}

function calculateUsedSquares($grid)
{
	$used = 0;

	foreach ($grid as $row) {
		foreach ($row as $square) {
			if ($square === 1) {
				$used++;
			}
		}
	}

	return $used;
}


// this is basically Day 10 wrapped in a function!
function getKnotHash($input)
{
	$listSize = 256;
	$rounds = 64;

	$standardlengths = [17, 31, 73, 47, 23];

	$list = [];
	for ($i = 0; $i < $listSize; $i++) {
		$list[] = $i;
	}

	$lengths = getLengths($input, $standardlengths);

	$skip = 0;
	$curPos = 0;

	for ($i = 0; $i < $rounds; $i++) {
		foreach ($lengths as $length) {
			$subList = getSubList($list, $curPos, $length, $listSize);

			$subList = array_reverse($subList);

			$list = applySubList($subList, $list, $curPos, $listSize);

			$curPos = ($curPos + $length + $skip) % $listSize;

			$skip++;
		}
	}

	$denseHash = calculateDenseHash($list);

	return getHexRepresentation($denseHash);
}

// functions to support the KnotHash
function getLengths($input, $standardlengths)
{
	$lengths = [];

	$input = trim($input);

	for ($i = 0; $i < strlen($input); $i++) {
		$lengths[] = ord($input[$i]);
	}

	return array_merge($lengths, $standardlengths);
}

function getSubList($list, $curPos, $length, $listSize)
{

	$subList = [];

	for ($i = 0; $i < $length; $i++) {
		$id = ($curPos + $i) % $listSize;
		$subList[] = $list[$id];
	}

	return $subList;
}

function applySubList($subList, $list, $curPos, $listSize)
{
	for ($i = 0; $i < count($subList); $i++) {
		$id = ($curPos + $i) % $listSize;
		$list[$id] = $subList[$i];
	}

	return $list;
}

function calculateDenseHash($list)
{
	$hash = [];

	for ($i = 0; $i < count($list); $i = $i + 16) {
		$num = $list[$i];
		for ($j = $i+1; $j < $i + 16; $j++) {
			$num = $num ^ $list[$j];
		}
		$hash[] = $num;
	}

	return $hash;
}

function getHexRepresentation($hash)
{
	$hex = '';

	for ($i = 0; $i < count($hash); $i++) {
		$hex .= str_pad(dechex($hash[$i]), 2, '0', STR_PAD_LEFT);
	}

	return $hex;
}