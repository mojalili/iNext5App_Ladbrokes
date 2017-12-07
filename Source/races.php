<?php

include_once 'competitor.php';
include_once 'race.php';

$raceTypes = array();
$raceTypes[0] = 'Thoroughbred';
$raceTypes[1] = 'Greyhounds';
$raceTypes[2] = 'Harness';

$now = gmdate("Y-m-d H:i:s");
$fiveHoursLater = gmdate("Y-m-d H:i:s", strtotime('+5 hours'));

$races = array();
for($i = 1; $i<= 20; $i++) {
    $race = new Race();
    $race->closingTime = rand_date($now, $fiveHoursLater);
    $race->type = $raceTypes[rand(0, 2)];
    $race->competitors = array();

    $randomPositions = get_unique_rand_within_range(1, 5, 5);
    for($j = 1; $j <= 5; $j++) {
        $competitor = new Competitor();
        $competitor->number = $j;
        $competitor->position = $randomPositions[$j - 1];
        $race->competitors[$j] = $competitor;
    }
    $races[$i] = $race;
}

echo json_encode($races);

function get_unique_rand_within_range($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

function rand_date($min_date, $max_date) {

    $min_epoch = strtotime($min_date);
    $max_epoch = strtotime($max_date);

    $rand_epoch = rand($min_epoch, $max_epoch);

    return date('Y-m-d H:i:s', $rand_epoch);
}
?>