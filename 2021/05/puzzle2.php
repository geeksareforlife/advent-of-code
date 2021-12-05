<?php

$readings = file("input");

// seabed is a square
$seabedSize = 1000;

// seabed, initial dimension is Y, secondary is X
$seabed = array_fill(0, $seabedSize, array_fill(0, $seabedSize, "."));

foreach ($readings as $reading) {
    $reading = parseReading($reading);
    
    if ($reading['x1'] == $reading['x2']) {
        $x = $reading['x1'];
        $start = min($reading['y1'], $reading['y2']);
        $end = max($reading['y1'], $reading['y2']);

        for ($i = $start; $i <= $end; $i++) {
            if ($seabed[$i][$x] == ".") {
                $seabed[$i][$x] = 1;
            } else {
                $seabed[$i][$x] = $seabed[$i][$x] + 1;
            }
        }
    } else if ($reading['y1'] == $reading['y2']) {
        $y = $reading['y1'];
        $start = min($reading['x1'], $reading['x2']);
        $end = max($reading['x1'], $reading['x2']);

        for ($i = $start; $i <= $end; $i++) {
            if ($seabed[$y][$i] == ".") {
                $seabed[$y][$i] = 1;
            } else {
                $seabed[$y][$i] = $seabed[$y][$i] + 1;
            }
        }
    } else {
        // we are in diagonal territory
        // if we ensure that x1 < x2, we simplipfy to two types of diagonal
        if ($reading['x1'] > $reading['x2']) {
            $x1 = $reading['x2'];
            $y1 = $reading['y2'];
            $x2 = $reading['x1'];
            $y2 = $reading['y1'];
        } else {
            $x1 = $reading['x1'];
            $y1 = $reading['y1'];
            $x2 = $reading['x2'];
            $y2 = $reading['y2'];
        }

        if ($y1 < $y2) {
            $deltaY = 1;
        } else {
            $deltaY = -1;
        }

        // how many points? X is always increasing
        $count = $x2 - $x1;

        for ($i = 0; $i <= $count; $i++) {
            $x = $x1 + $i;
            $y = $y1 + ($deltaY * $i);
            if ($seabed[$y][$x] == ".") {
                $seabed[$y][$x] = 1;
            } else {
                $seabed[$y][$x] = $seabed[$y][$x] + 1;
            }
        }
    }

}

$avoid = countAvoidPoints($seabed);

echo("There are " . $avoid . " points to avoid\n");

function countAvoidPoints($seabed)
{
    $points = 0;

    foreach ($seabed as $rows) {
        foreach ($rows as $point) {
            if ($point >= 2) {
                $points++;
            }
        }
    }

    return $points;
}

function parseReading($reading)
{
    $parts = explode(" -> ", trim($reading));
    $coords = [];
    for ($i = 0; $i < count($parts); $i++) {
        list($x, $y) = explode(",", $parts[$i]);

        $coords["x" . ($i+1)] = intval($x);
        $coords["y" . ($i+1)] = intval($y);
    }
    return $coords;
}

function printSeabed($seabed)
{
    echo("SEA BED\n");
    foreach ($seabed as $row) {
        echo(implode("", $row) . "\n");
    }
    echo("END SEA BED\n");
}