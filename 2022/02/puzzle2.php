<?php

$input = file("input");

/*
A = Rock     (1)
B = Paper    (2)
C = Scissors (3)

X = lose (0)
Y = draw (3)
Z = win  (6)

*/

$plays = [
    'A' => [
        'X' => 3 + 0,
        'Y' => 1 + 3,
        'Z' => 2 + 6
    ],
    'B' => [
        'X' => 1 + 0,
        'Y' => 2 + 3,
        'Z' => 3 + 6
    ],
    'C' => [
        'X' => 2 + 0,
        'Y' => 3 + 3,
        'Z' => 1 + 6
    ]
];

$outcomes = [];

// very confusingly changed the meaning of play and response between puzzle 1 and 2!
foreach ($plays as $play => $responses) {
    foreach($responses as $response => $score) {
        $outcomes[$play . ' ' . $response] = $score;
    }
}

$total = 0;

foreach ($input as $round) {
    $round = trim($round);
    $total += $outcomes[$round];
}

echo("The total score would be " . $total . "\n");