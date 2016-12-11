<?php

$input = file('input');

// this pattern will match ABBA type and AAAA type
$pattern = '([a-z])([a-z])\2\1';

$supportTLS = array();
$noTLS = array();

foreach ($input as $ip) {
	// any ABBA in hypernets?
	if (preg_match('/\[[a-z]*' . $pattern . '[a-z]*\]/', $ip, $matches)) {
		// possible ABBA pattern within square brakets
		if (isABBA($matches[1], $matches[2])) {
			$noTLS[] = $ip;
			continue;
		}
	}

	// any other ABBAs?
	if (preg_match_all('/' . $pattern . '/', $ip, $matches)) {
		if (isABBA($matches[1], $matches[2])) {
			$supportTLS[] = $ip;
			continue;
		} else {
			$noTLS[] = $ip;
			continue;
		}
	} else {
		$noTLS[] = $ip;
		continue;
	}
}

echo("SUPPORT:    " . count($supportTLS) . "\n");
echo("NO SUPPORT: " . count($noTLS) . "\n");



function isABBA($a, $b) {
	if (is_array($a)) {
		$return = false;
		for ($i = 0; $i < count($a); $i++) {
			if ($a[$i] != $b[$i]) {
				$return = true;
			}
		}
		return $return;
	} else {
		if ($a == $b) {
			return false;
		} else {
			return true;
		}
	}
}