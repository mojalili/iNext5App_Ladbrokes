<?php

include_once 'competitor.php';
include_once 'race.php';

$raceTypes = array();
$raceTypes[0] = 'Thoroughbred';
$raceTypes[1] = 'Greyhounds';
$raceTypes[2] = 'Harness';

$now = new DateTime(null, new DateTimeZone("UTC"));

$races = array();
for($i = 1; $i<= 20; $i++) {
    $race = new Race();
    $secondsToAdd = sprintf('PT%dS', rand(1, 800));
    $race->closingTime = (clone $now)->add(new DateInterval($secondsToAdd))->format("c");
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
usort($races, 'sort_by_time');
$next5 = array_slice($races, 0, 5);
$json = json_encode($next5);

echo $json;

function sort_by_time($race1, $race2){
    return $race1->closingTime <=> $race2->closingTime;
}

function get_unique_rand_within_range($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 0, $quantity);
}

?>