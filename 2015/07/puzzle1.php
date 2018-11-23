<?php
$instructions = file('input.puzzle2');

$wires = [];

while (count($instructions) > 0) {
	$instruction = trim(array_shift($instructions));

	
	if (preg_match('/^([a-z]+|\d+) -> ([a-z]+)$/', $instruction, $matches)) {
		// put number onto wire, can always do this!
		if (getWireValue($matches[1]) === false) {
			// can't complete this function yet, skip
			//echo("Skipping: " . $instruction . "\n");
			array_push($instructions, $instruction);
		} else {
			if (is_numeric($matches[1])) {
				$wires[$matches[2]] = unsigned16GetBinary($matches[1]);
			} else {
				$wires[$matches[2]] = getWireValue($matches[1]);
			}
			echo($matches[2] . " set to " . getWireValue($matches[2]) . "\n");
		}
	} elseif (preg_match('/^NOT ([a-z]+|\d+) -> ([a-z]+)$/', $instruction, $matches)) {
		// NOT instruction
		if (getWireValue($matches[1]) === false) {
			// can't complete this function yet, skip
			//echo("Skipping: " . $instruction . "\n");
			array_push($instructions, $instruction);
		} else {
			$wires[$matches[2]] = unsigned16Not(getWireValue($matches[1]));
			echo($matches[2] . " set to " . getWireValue($matches[2]) . "\n");
		}
	} elseif (preg_match('/^([a-z]+|\d+) (AND|OR|LSHIFT|RSHIFT) ([a-z]+|\d+) -> ([a-z]+)$/', $instruction, $matches)) {
		if (getWireValue($matches[1]) === false || getWireValue($matches[3]) === false) {
			// can't complete this function yet, skip
			//echo("Skipping: " . $instruction . "\n");
			array_push($instructions, $instruction);
		} else {
			if (is_numeric($matches[1])) {
				$matches[1] = unsigned16GetBinary($matches[1]);
			}
			switch ($matches[2]) {
				case 'AND':
					$wires[$matches[4]] = unsigned16And(getWireValue($matches[1]), getWireValue($matches[3]));
					echo($matches[4] . " set to " . getWireValue($matches[4]) . "\n");
					break;
				
				case 'OR':
					$wires[$matches[4]] = unsigned16Or(getWireValue($matches[1]), getWireValue($matches[3]));
					echo($matches[4] . " set to " . getWireValue($matches[4]) . "\n");
					break;

				case 'LSHIFT':
					$wires[$matches[4]] = unsigned16Lshift(getWireValue($matches[1]), $matches[3]);
					echo($matches[4] . " set to " . getWireValue($matches[4]) . "\n");
					break;

				case 'RSHIFT':
					$wires[$matches[4]] = unsigned16Rshift(getWireValue($matches[1]), $matches[3]);
					echo($matches[4] . " set to " . getWireValue($matches[4]) . "\n");
					break;

				default:
					# code...
					break;
			}
		}
	} else {
		echo("Instruction not matched:\n");
		echo($instruction . "\n");
		die;
	}
}


outputWires($wires);


function getWireValue($wire)
{
	global $wires;

	if (is_numeric($wire)) {
		return $wire;
	} elseif (isset($wires[$wire])) {
		return $wires[$wire];
	} else {
		return false;
	}
}

function outputWires($wires)
{
	for ($x = 'a'; $x != 'zz'; $x++) {
		if (isset($wires[$x])) {
			echo(str_pad($x, 2, " ", STR_PAD_LEFT) . ": ");
			echo(bindec($wires[$x]));
			echo("\n");
		}
	}
}



// PHP doesn't support 16 bit unsigned integers, so, here we go!

function unsigned16GetBinary($number)
{
	if ($number < 0) {
		return false;
	} else {
		return str_pad(decbin($number), 16, "0", STR_PAD_LEFT);
	}
}

function is16Binary($binary)
{
	if (is_string($binary) && strlen($binary) == 16) {
		return true;
	} else {
		return false;
	}
}

function unsigned16Not($binary)
{
	if (is16Binary($binary)) {
		$return = "";
		for ($i = 0; $i < strlen($binary); $i++) {
			$return .= $binary[$i] == 0 ? 1 : 0;
		}
		return $return;
	} else {
		return false;
	}
}

function unsigned16And($binaryA, $binaryB)
{
	if (is16Binary($binaryA) && is16Binary($binaryB)) {
		$return = "";
		for ($i = 0; $i < strlen($binaryA); $i++) {
			$return .= $binaryA[$i] == $binaryB[$i] ? $binaryA[$i] : 0;
		}
		return $return;
	} else {
		return false;
	}
}

function unsigned16Or($binaryA, $binaryB)
{
	if (is16Binary($binaryA) && is16Binary($binaryB)) {
		$return = "";
		for ($i = 0; $i < strlen($binaryA); $i++) {
			$return .= ($binaryA[$i] + $binaryB[$i]) > 0 ? 1 : 0;
		}
		return $return;
	} else {
		return false;
	}
}

function unsigned16Lshift($binary, $amount)
{
	if (is16Binary($binary)) {
		return str_pad(substr($binary, $amount), 16, "0", STR_PAD_RIGHT);
	} else {
		return false;
	}
}

function unsigned16Rshift($binary, $amount)
{
	if (is16Binary($binary)) {
		return str_pad(substr($binary, 0, 16-$amount), 16, "0", STR_PAD_LEFT);
	} else {
		return false;
	}
}