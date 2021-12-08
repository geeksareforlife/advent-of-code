<?php

$signals = file("input");

$total = 0;

foreach ($signals as $signal) {
    list($patterns, $output) = explode(" | ", trim($signal));

    $mapping = decodePatterns($patterns);
    
    $outputValue = getOutput($output, $mapping);
    $total = $total + $outputValue;
}

echo("The total is " . $total . "\n");

function decodePatterns($patternList)
{
    $patterns = explode(" ", $patternList);
    
    $knownNumbers = [];
    $mapping = [
        /*
        "" => "a", // in 0,2,3,5,6,7,8,9
        "" => "b", // in 0,4,5,6,8,9
        "" => "c", // in 0,1,2,3,4,7,8,9
        "" => "d", // in 2,3,4,5,6,8,9
        "" => "e", // in 0,2,6,8
        "" => "f", // in 0,1,3,4,5,6,7,8
        "" => "g", // in 0,2,3,5,6,8,9
        */
    ];

    // first pass, let's get 1,4,7 and 8
    // let's also split into arrays
    // 1 has two output signals
    // 4 has four output signals
    // 7 has three output signals
    // 8 has seven output signals
    $unknownPatterns = [];
    foreach ($patterns as $pattern) {
        if (strlen($pattern) == 2) {
            $knownNumbers[1] = str_split($pattern);
        } else if(strlen($pattern) == 3) {
            $knownNumbers[7] = str_split($pattern);
        } else if(strlen($pattern) == 4) {
            $knownNumbers[4] = str_split($pattern);
        } else if (strlen($pattern) == 7) {
            $knownNumbers[8] = str_split($pattern);
        } else {
            $unknownPatterns[] = str_split($pattern);
        }
    }
    
    // there will only be two letters the same in all of these
    // these will map to c and f (but don't know which way round yet)
    $cf = $knownNumbers[1];

    // 7 is acf, so now we know a!
    $a = array_diff($knownNumbers[7], $cf);
    $mapping[implode($a)] = 'a';


    // 4 is made up of cf, which we know and bd
    $bd = array_diff($knownNumbers[4], $cf);

    // now we know a, bd and cf, we can use 8 to find eg
    $eg = array_diff($knownNumbers[8], $a, $bd, $cf);

    
    // now to work out the pairs
    // 0 is abcefg. if we combine a, cf and eg, we can then work out b and d!
    // 9 is abcdfg. If we combine a, bd and cf we can then work out g and e!
    // 6 is abdefg. If we combine a, bd and eg, we can then work out f and c!
    $test0 = array_merge($a, $cf, $eg);
    $test9 = array_merge($a, $bd, $cf);
    $test6 = array_merge($a, $bd, $eg);

    for ($i = 0; $i < count($unknownPatterns); $i++) {
        $pattern = $unknownPatterns[$i];
        // 0 has 6 segements, only care about that
        if (count($pattern) == 6) {
            $b = array_diff($pattern, $test0);
            $g = array_diff($pattern, $test9);
            $f = array_diff($pattern, $test6);
            if (count($b) == 1) {
                $mapping[implode($b)] = 'b';
                $mapping[implode(array_diff($bd, $b))] = 'd';
            } else if (count($g) == 1) {
                $mapping[implode($g)] = 'g';
                $mapping[implode(array_diff($eg, $g))] = 'e';
            } else if (count($f) == 1) {
                $mapping[implode($f)] = 'f';
                $mapping[implode(array_diff($cf, $f))] = 'c';
            }
        }
    }

    return $mapping;
}

function getOutput($output, $mapping)
{
    $numbers = [
        "abcefg"    => 0,
        "cf"        => 1,
        "acdeg"     => 2,
        "acdfg"     => 3,
        "bcdf"      => 4,
        "abdfg"     => 5,
        "abdefg"    => 6,
        "acf"       => 7,
        "abcdefg"   => 8,
        "abcdfg"    => 9,
    ];

    $outputValue = "";

    $outputNumbers = explode(" ", $output);

    foreach ($outputNumbers as $coded) {
        $numberString = mapSignals($coded, $mapping);
        $outputValue = $outputValue . $numbers[$numberString];
    }

    return intval($outputValue);
}

function mapSignals($coded, $mapping)
{
    $letters = str_split($coded);
    
    $number = [];

    foreach ($letters as $letter) {
        $number[] = $mapping[$letter];
    }
    asort($number);

    return implode($number);
}
