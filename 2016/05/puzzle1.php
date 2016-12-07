<?php

$input = 'cxdnnyjw';

$id = 0;

$password = '';

while (strlen($password) < 8) {
	$hash = md5($input . $id);

	if (substr($hash, 0, 5) === '00000') {
		$password .= substr($hash, 5, 1);
	}

	$id++;
}

echo("ID      : " . $id . "\n");
echo("PASSWORD: " . $password . "\n");