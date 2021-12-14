<?php

// first get a representation of the caves
$connections = file("input");

$caves = [];

foreach ($connections as $connection) {
    list($cave1, $cave2) = explode("-", trim($connection));

    if (!isset($caves[$cave1])) {
        $caves[$cave1] = [];
    }
    if (!isset($caves[$cave2])) {
        $caves[$cave2] = [];
    }

    $caves[$cave1][] = $cave2;
    $caves[$cave2][] = $cave1;
}

$paths = findPaths($caves, "start");

displayPaths($paths);

echo("There are " . count($paths) . " paths through the caves\n");

function findPaths($caves, $currentCave, $path = [], $paths = [])
{
    //echo("Current: " . $currentCave . "\n");
    $path[] = $currentCave;
    //echo("Path: " . implode(",", $path) . "\n");
    foreach ($caves[$currentCave] as $newCave) {
        $thisPath = $path;
        //echo("New: " . $newCave . "\n");
        if (in_array($newCave, $path) and ctype_lower($newCave)) {
            // can't visit a small cave twice
            //echo("throw away\n");
        } else if ($newCave == "end") {
            // We have completed this path
            $thisPath[] = $newCave;
            $paths[] = $thisPath;
            //echo("END!\n");
        } else {
            //echo("add to path...\n");
            $paths = findPaths($caves, $newCave, $thisPath, $paths);
        }
    }
    return $paths;
}

function displayPaths($paths)
{
    foreach ($paths as $path) {
        echo(implode(",", $path) . "\n");
    }
}

function displayCaves($caves)
{
    foreach ($caves as $cave => $connections) {
        echo($cave . " : " . implode(", ", $connections) . "\n");
    }
}