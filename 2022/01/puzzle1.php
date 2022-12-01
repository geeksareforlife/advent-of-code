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

echo("The elf with the largest number of calories has " . max($totals) . " calories\n");