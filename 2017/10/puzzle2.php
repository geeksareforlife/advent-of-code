<?php

$input = file_get_contents('input');
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
		$subList = getSubList($list, $curPos, $length);

		$subList = array_reverse($subList);

		$list = applySubList($subList, $list, $curPos);

		$curPos = ($curPos + $length + $skip) % $listSize;

		$skip++;
	}
}

$denseHash = calculateDenseHash($list);

$hex = getHexRepresentation($denseHash);

var_dump($hex);

function getLengths($input, $standardlengths)
{
	$lengths = [];

	$input = trim($input);

	for ($i = 0; $i < strlen($input); $i++) {
		$lengths[] = ord($input[$i]);
	}

	return array_merge($lengths, $standardlengths);
}

function getSubList($list, $curPos, $length)
{
	global $listSize;

	$subList = [];

	for ($i = 0; $i < $length; $i++) {
		$id = ($curPos + $i) % $listSize;
		$subList[] = $list[$id];
	}

	return $subList;
}

function applySubList($subList, $list, $curPos)
{
	global $listSize;

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