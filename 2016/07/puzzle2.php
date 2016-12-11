<?php

$input = file('input');

$supportSSL = array();
$noSSL = array();


foreach ($input as $ip) {
	$ip = trim($ip);
	$remain = $ip;

	$inHyperNet = false;
	$support = false;

	while (strlen($remain) > 0) {
		$a = substr($remain, 0, 1);
		$b = substr($remain, 1, 1);
		$c = substr($remain, 2, 1);

		$search = substr($remain, 3);

		$remain = substr($remain, 1);

		// have we moved into or out of a hypernet?
		if ($a == '[') {
			$inHyperNet = true;
			continue;
		} elseif ($a == ']') {
			$inHyperNet = false;
			continue;
		} elseif ($b == '[' or $b == ']' or $c == '[' or $c == ']') {
			// can't make a sequence
			continue;
		} elseif (($a == $c) and ($a != $b)) {
			// ABA sequence
			$bab = $b . $a . $b;

			if ($inHyperNet) {
				// we need to find the reverse outside a hypernet
				// we know that one must have already started, because we're in it!
				if (preg_match('/\][a-z]*' . $bab . '/', $search)) {
					$support = true;
					break;
				}
			} else {
				// we need to find the reverse within a hypernet
				if (preg_match('/\[[a-z]*' . $bab . '[a-z]*\]/', $search)) {
					$support = true;
					break;
				}
			}
		}	
	}

	if ($support) {
		$supportSSL[] = $ip;
	} else {
		$noSSL[] = $ip;
	}
}

echo("SUPPORT:    " . count($supportSSL) . "\n");
echo("NO SUPPORT: " . count($noSSL) . "\n");

function isABA($a, $b) {
	if ($a == $b) {
		return false;
	} else {
		return true;
	}
}