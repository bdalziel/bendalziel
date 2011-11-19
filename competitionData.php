<?php

require('runkeeper.php');

$username = 'tigerkitten';
$junkMonths = 9;
$html = getUserActivities($username);
$activitiesData = getCompetitionActivityData($username, $html, $junkMonths);
$data = array();
foreach ($activitiesData as $activityData) {
    $data[] =  $activityData['date'] . ", " . $activityData['distance'];
}
$data = implode($data, "\n");

print $data;





$username = "DaddyRoundRound";
$junkMonths = 6;
$html = getUserActivities($username);
$activitiesData = getCompetitionActivityData($username, $html, $junkMonths);
$data = array();
foreach ($activitiesData as $activityData) {
    $data[] =  $activityData['date'] . ", " . $activityData['distance'];
}
$data = implode($data, "\n");

print $data;

?>
