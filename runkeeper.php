<?php

function getUserActivities ($user) {
    $query = "http://runkeeper.com/user/" . $user . "/activity";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    $html = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $startChar = strpos($html, "id=\"activityHistoryMenu\"") + (strlen("id=\"activityHistoryMenu\"") + 1);
    $endChar = strpos($html, "id=\"mainColumn\"");
    return substr($html, $startChar, $endChar - $startChar);
}

function getCompetitionTotalMiles ($html, $numberOfJunkMonths) {

    $monthActivityCounts = array();
    preg_match_all('~<div class="bubble-text">(.*?)</div>~is', $html, $monthCounts);
    foreach ($monthCounts[1] as $monthCount) {
        $monthActivityCounts[] = $monthCount;
    }
    $monthActivityCounts = array_slice($monthActivityCounts, 0, sizeof($monthActivityCounts) - $numberOfJunkMonths);

    $activityDistances = array();
    preg_match_all('~<div class="distance">(.*?)</div>~is', $html, $distances);
    foreach ($distances[1] as $distance) {
        $activityDistances[] = $distance;
    }

    $monthActivities = array();

    $activitiesTotal = (float) 0;


    $activityIndex = 0;
    foreach ($monthActivityCounts as $i => $monthActivityCount) {
        $monthActivities[$i] = array();
        for ($j = 0; $j < $monthActivityCount; $j++) {
            $monthActivities[$i][] = $activityDistances[$activityIndex];
            $activitiesTotal += $activityDistances[$activityIndex];
            $activityIndex++;
        }
    }
    return $activitiesTotal;
}



/*
$benMiles = $rk->get('miles', array(
                                    'username' => "tigerkitten",
                                    'min_date' => '09/22/2011',
                                    'max_date' => '01/01/2012',
                                    'type'     => 'run'
                                    ));

$crisMiles = $rk->get('miles', array(
                                     'username' => "DaddyRoundRound",
                                     'min_date' => '09/22/2011',
                                     'max_date' => '01/01/2012',
                                     'type'     => 'cycling'
                                     ));
*/

?>
