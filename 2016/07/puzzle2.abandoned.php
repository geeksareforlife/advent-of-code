<?php

$input = file('input');

$supportSSL = array();
$noSSL = array();

foreach ($input as $ip) {
	$ip = trim($ip);
	if (preg_match_all('/([a-z])([a-z])\1.*\[[a-z]*\2\1\2[a-z]*\]/', $ip, $matches)) {
		if (isABA($matches[1], $matches[2])) {
			$supportSSL[] = $ip;
		} else {
			$noSSL[] = $ip;
		}
	} elseif (preg_match_all('/\[[a-z]*([a-z])([a-z])\1[a-z]*\].*\2\1\2/', $ip, $matches)) {
		if (isABA($matches[1], $matches[2])) {
			$supportSSL[] = $ip;
		} else {
			$noSSL[] = $ip;
		}
	} else {
		$noSSL[] = $ip;
	}
}

echo("SUPPORT:    " . count($supportSSL) . "\n");
echo("NO SUPPORT: " . count($noSSL) . "\n");

function isABA($a, $b) {
	$return = false;
	if (is_array($a)) {
		for ($i = 0; $i < count($a); $i++) {
			if ($a[$i] != $b[$i]) {
				$return = true;
			}
		}
	} else {
		if ($a == $b) {
			$return = false;
		} else {
			$return = true;
		}
	}
	return $return;
}