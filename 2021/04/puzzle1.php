<?php

$called = str_getcsv(trim(file_get_contents("input.numbers")));

for ($i = 0; $i < count($called); $i++) {
    $called[$i] = intval($called[$i]);
}

$boards = parseBoards("input.boards");

// run bingo!
foreach ($called as $number) {
    echo("called: " . $number . "\n");
    for ($i = 0; $i < count($boards); $i++) {
        $boards[$i] = markBoard($boards[$i], $number);

        if (checkBoard($boards[$i])) {
            echo("Winner! Board " . ($i+1) . "\n");
            echo("Score: " . scoreBoard($boards[$i], $number) . "\n");
            break 2;
        }
    }
    echo("No winners this round\n");
}

function markBoard($board, $number)
{
    // check rows
    for ($i = 0; $i < count($board['rows']); $i++) {
        for ($j = 0; $j < count($board['rows'][$i]); $j++) {
            if ($board['rows'][$i][$j] == $number) {
                $board['rows'][$i][$j] = "-";
            }
        }
    }

    // check columns
    for ($i = 0; $i < count($board['columns']); $i++) {
        for ($j = 0; $j < count($board['columns'][$i]); $j++) {
            if ($board['columns'][$i][$j] == $number) {
                $board['columns'][$i][$j] = "-";
            }
        }
    }

    return $board;
}

function checkBoard($board)
{
    $check = ["-","-","-","-","-"];
    // check rows
    for ($i = 0; $i < count($board['rows']); $i++) {
        if ($board['rows'][$i] == $check) {
            return true;
        }
    }

    // check columns
    for ($i = 0; $i < count($board['columns']); $i++) {
        if ($board['columns'][$i] == $check) {
            return true;
        }
    }

    return false;
}

function scoreBoard($board, $called)
{
    $sum = 0;

    foreach($board['rows'] as $row) {
        $sum = $sum + array_sum($row);
    }

    return $called * $sum;
}


function parseBoards($file)
{
    $lines = file($file);

    $boards = [];
    $board = [];

    for ($i = 0; $i < count($lines); $i = $i + 6) {
        $board = [
            $lines[$i],
            $lines[$i+1],
            $lines[$i+2],
            $lines[$i+3],
            $lines[$i+4],
        ];
        $boards[] = parseBoard($board);
    }

    return $boards;
}

function parseBoard($lines)
{
    $cols = [];
    $rows = [];

    for ($i = 0; $i < count($lines); $i++) {
        $numbers = parseLine($lines[$i]);
        $rows[] = $numbers;
        for ($j = 0; $j < count($numbers); $j++) {
            if (!isset($cols[$j])) {
                $cols[$j] = [];
            }
            $cols[$j][$i] = $numbers[$j];
        }
    }

    return [
        'columns'   => $cols,
        'rows'      => $rows,
    ];
}

function parseLine($line)
{
    // 2 characters for each number, 1 space in between
    $split = str_split($line, 3);
    $numbers = [];

    for ($i = 0; $i < count($split); $i++) {
        $numbers[] = intval($split[$i]);
    }

    return $numbers;
}