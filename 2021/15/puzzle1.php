<?php

$input = file("input.test");

// x,y representation, with y as the 1st dimension
$caves = [];

foreach ($input as $line) {
    $caves[] = array_map("intval", str_split(trim($line)));
}

// we'll make an estimation of maximum total risk
// this is what we want to beat
$totalRisk = (count($caves) * 9) + (count($caves[0]) * 9);

$path = findPath($caves, ['x' => 0, 'y' => 0], $totalRisk);


function findPath($caves, $position, $totalRisk, $paths = [])
{
    
}