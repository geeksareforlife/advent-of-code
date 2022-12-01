<?php

$input = file("input");


$elves = [];

$elf = [
    "total"     => 0,
    "entries"   => []
];

$totals = [];

for ($line = 0; $line < count($input); $line++) {
    if ($input[$line] == "\n") {
        $elves[] = $elf;
        $totals[] = $elf['total'];
        $elf = [
            "total"     => 0,
            "entries"   => []
        ];
        continue;
    } else {
        $calories = intval(trim($input[$line]));
        $elf['total'] += $calories;
        $elf['entries'][] = $calories;
    }
}

$elves[] = $elf;
$totals[] = $elf['total'];

sort($totals);

$grandtotal = array_pop($totals) + array_pop($totals) + array_pop($totals);

echo("The top three elves are carrying " . $grandtotal . " calories between them\n");