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
        if ($newCave == "start") {
            // nope!
            //echo("throw away\n");
        } else if (in_array($newCave, $path) and ctype_lower($newCave)) {
            // we can visit one small cave twice
            if (canVisitCave($path, $newCave)) {
                //echo("add to path...\n");
                $paths = findPaths($caves, $newCave, $thisPath, $paths);
            } else {
                // echo("throw away\n");
            }
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

function canVisitCave($path, $newCave)
{
    $visited = array_count_values($path);

    if ($visited[$newCave] == 2) {
        return false;
    } else {
        // we can, as long as no other small cave has been visited twice
        foreach ($visited as $cave => $count) {
            if (ctype_lower($cave) and $count == 2) {
                return false;
            }
        }
        return true;
    }
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