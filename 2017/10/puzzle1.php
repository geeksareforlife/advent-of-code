<?php

$input = file_get_contents('input');
$listSize = 256;

$list = [];
for ($i = 0; $i < $listSize; $i++) {
	$list[] = $i;
}

$lengths = array_map('intval', explode(',', trim($input)));

$skip = 0;
$curPos = 0;

foreach ($lengths as $length) {
	$subList = getSubList($list, $curPos, $length);

	$subList = array_reverse($subList);

	$list = applySubList($subList, $list, $curPos);

	$curPos = ($curPos + $length + $skip) % $listSize;

	$skip++;
}

$checkSum = $list[0] * $list[1];

echo("The checksum is " . $checkSum . "\n");


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
