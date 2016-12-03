<?php

$input = 'iwrupvqb';

$num = 1;

while (1) {
	$md5 = md5($input . $num);
	if (strpos($md5, '00000') === 0) {
		break;
	}
	$num++;
}

echo($num . "\n");