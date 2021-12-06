<?php

$fishList = str_getcsv(file_get_contents("input"));

$fishGroups = [];

// parse fishList into groups
$groups = array_count_values($fishList);
foreach ($groups as $life => $count) {
    $fishGroups[] = [
        'life'  => intval($life),
        'count' => $count,
    ];
}

// run simulation
$days = 256;

for ($day = 1; $day <= $days; $day++) {
    // assume we are not going to get a new group
    $newGroup = [];

    for ($i = 0; $i < count($fishGroups); $i++) {
        if ($fishGroups[$i]['life'] == 0) {
            $newGroup = [
                'life'  => 8,
                'count' => $fishGroups[$i]['count'],
            ];
            $fishGroups[$i]['life'] = 6;
        } else {
            $fishGroups[$i]['life'] = $fishGroups[$i]['life'] - 1;
        }
    }

    if ($newGroup !== []) {
        $fishGroups[] = $newGroup;
    }

    $fishGroups = combineGroups($fishGroups);
}

$fishCount = countFish($fishGroups);

echo("After " . $days . " days, there would be " . $fishCount . " fish\n");

function combineGroups($fishGroups)
{
    $lifeIndex = [];
    $newGroups = [];

    foreach ($fishGroups as $group) {
        if (isset($lifeIndex[$group['life']])) {
            $newGroups[$lifeIndex[$group['life']]]['count'] = $newGroups[$lifeIndex[$group['life']]]['count'] + $group['count'];
        } else {
            $newGroups[] = $group;
            $lifeIndex[$group['life']] = count($newGroups) - 1;
        }
    }

    return $newGroups;
}

function countFish($fishGroups)
{
    $count = 0;

    foreach ($fishGroups as $group) {
        $count = $count + $group['count'];
    }

    return $count;
}