<?php

$input = 'iwrupvqb';

$num = 346386;

while (1) {
	$md5 = md5($input . $num);
	if (strpos($md5, '000000') === 0) {
		break;
	}
	$num++;
}

echo($num . "\n");