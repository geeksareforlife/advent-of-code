<?php
$test = false;

// read the paper and instructions from input
if ($test) {
    $input = file("input.test");
    $maxX = 11;
    $maxY = 15;
} else {
    $input = file("input");
    $maxX = 1310;
    $maxY = 890;
}


// this is a multidimensional array, with y as 1st and x as 2nd
$paper = array_fill(0, $maxY, array_fill(0, $maxX, '.'));

$instructions = [];

$inInstructions = false;
foreach ($input as $line) {
    if (trim($line) == "") {
        $inInstructions = true;
    } else if ($inInstructions) {
        list($axis, $location) = explode("=", str_replace("fold along ", "", trim($line)));
        $instructions[] = [
            'axis'      => $axis,
            'location'  => $location,
        ];
    } else {
        list($x,$y) = explode(",", trim($line));
        $paper[$y][$x] = '#';
    }
}

foreach ($instructions as $instruction) {
    $paper = fold($paper, $instruction);
}

showPaper($paper);



function showPaper($paper)
{
    foreach ($paper as $line) {
        echo(implode("", $line) . "\n");
    }
}

function fold($paper, $instruction)
{
    if ($instruction['axis'] == 'y') {
        // start with the paper above the fold
        $newPaper = array_slice($paper, 0, $instruction['location']);
        // the next half will need flipping and applying to newPaper
        // but if it is shorter, make up the extra
        $folded = array_slice($paper, $instruction['location']+1, $instruction['location']);
        
        $diff = count($newPaper) - count($folded);
        if ($diff > 0) {
            for ($i = 0; $i < $diff; $i++) {
                $folded[] = array_fill(0, count($folded[0]), '.');
            }
        }
        $folded = array_reverse($folded);
        
        // and apply
        for ($y = 0; $y < count($folded); $y++) {
            for ($x = 0; $x < count($folded[$y]); $x++) {
                if ($folded[$y][$x] == "#") {
                    $newPaper[$y][$x] = '#';
                }
            }
        }

        return $newPaper;
    } else if ($instruction['axis'] == 'x') {
        $newPaper = [];
        foreach ($paper as $line) {
            $newLine = array_slice($line, 0, $instruction['location']);

            // the next half will need flipping and applying to newPaper
            // but if it is shorter, make up the extra
            $folded = array_slice($line, $instruction['location']+1, $instruction['location']);

            $diff = count($newLine) - count($folded);
            if ($diff > 0) {
                for ($i = 0; $i < $diff; $i++) {
                    $folded[] = '.';
                }
            }
            $folded = array_reverse($folded);

            for ($x = 0; $x < count($folded); $x++) {
                if ($folded[$x] == '#') {
                    $newLine[$x] = '#';
                }
            }
            $newPaper[] = $newLine;
        }
        return $newPaper;
    } else {
        return $paper;
    }
}