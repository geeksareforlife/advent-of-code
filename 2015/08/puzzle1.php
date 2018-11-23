<?php
$items = file('input');

$codeChars = 0;
$memoryChars = 0;

foreach ($items as $item) {
	$item = trim($item);

	echo($item . " : " . strlen($item) . "\n");
	echo(myEscape(substr($item, 1, strlen($item)-2)) . " : " . strlen(myEscape(substr($item, 1, strlen($item)-2))) . "\n");

	$codeChars += strlen($item);
	$memoryChars += strlen(myEscape(substr($item, 1, strlen($item)-2)));
}

echo("Code Chars: " . $codeChars . "\n");
echo("Memory Chars: " . $memoryChars . "\n");
echo("Difference: " . ($codeChars - $memoryChars) . "\n");

function myEscape($string)
{
	// basic replacement
	$string = str_replace('\"', '"', $string);
	$string = str_replace('\\\\', '\\', $string);

	// we don't actually care what the character is, it takes up one space
	if (preg_match_all('/\\\\x([A-Za-z0-9]{2})/', $string, $matches)) {
		foreach ($matches[1] as $match) {
			$string = str_replace('\\x' . $match, "A", $string);
		}
	}

	return $string;
}