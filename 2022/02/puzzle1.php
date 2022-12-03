<?php

$input = file("input");

/*
X/A = Rock
Y/B = Paper
Z/C = Scissors
 */

$plays = [
    'X' => [
        'responses' => [
            'A'     => 3,
            'B'     => 0,
            'C'     => 6
        ],
        'score' => 1
    ],
    'Y' => [
        'responses' => [
            'A'     => 6,
            'B'     => 3,
            'C'     => 0
        ],
        'score' => 2
    ],
    'Z' => [
        'responses' => [
            'A'     => 0,
            'B'     => 6,
            'C'     => 3
        ],
        'score' => 3
    ]
];

$outcomes = [];

foreach ($plays as $play => $detail) {
    foreach($detail['responses'] as $response => $score) {
        $outcomes[$response . ' ' . $play] = $detail['score'] + $score;
    }
}

$total = 0;

foreach ($input as $round) {
    $round = trim($round);
    $total += $outcomes[$round];
}

echo("The total score would be " . $total . "\n");

