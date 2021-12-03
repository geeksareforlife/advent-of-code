<?php

$numbers = file('input');

$bits = [];

foreach ($numbers as $number) {
    $number = trim($number);
    for ($i = 0; $i < strlen($number); $i++) {
        if (count($bits) < strlen($number)) {
            $bits[] = ["0" => 0, "1" => 0];
        }
        $bits[$i][$number[$i]]++;
    }
}

$gamma = "";
$epsilon = "";

foreach ($bits as $bit) {
    if ($bit["0"] > $bit["1"]) {
        $gamma .= "0";
        $epsilon .= "1";
    } else {
        $gamma .= "1";
        $epsilon .= "0";
    }
}

$powerConsumption = bindec($gamma) * bindec($epsilon);

echo("Gamma is " . $gamma . " (" . bindec($gamma) . "), epsilon is " . $epsilon . " (" . bindec($epsilon) . ") making power consumption " . $powerConsumption . "\n");